<?php
class AdminController {
    public function dashboard() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        require "views/admin/dashboard.php";
    }

    public function manageProducts() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $products = $pdo->query("SELECT p.*, c.name as category_name FROM products p 
                                 LEFT JOIN categories c ON p.category_id = c.id 
                                 ORDER BY p.id DESC")->fetchAll();
        require "views/admin/products.php";
    }

    public function createProduct() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
        require "views/admin/create_product.php";
    }

    public function editProduct() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $id = (int)($_GET["id"] ?? 0);
        $productModel = new Product();
        $product = $productModel->getById($id);
        $categories = $pdo->query("SELECT * FROM categories")->fetchAll();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $name = sanitize($_POST["name"]);
            $price = (float)$_POST["price"];
            $stock = (int)$_POST["stock"];
            $category_id = (int)$_POST["category_id"];
            $description = sanitize($_POST["description"]);

            $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, category_id=? WHERE id=?");
            $stmt->execute([$name, $description, $price, $stock, $category_id, $id]);
            $_SESSION["success"] = "Product updated successfully.";
            redirect("index.php?controller=admin&action=manageProducts");
        }
        require "views/admin/edit_product.php";
    }

    public function deleteProduct() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        $id = (int)($_GET["id"] ?? 0);
        if ($id > 0) {
            global $pdo;
            try {
                $pdo->prepare("DELETE FROM order_items WHERE product_id = ?")->execute([$id]);
                $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
                $_SESSION["success"] = "Product deleted successfully.";
            } catch (Exception $e) {
                $_SESSION["error"] = "Cannot delete product. It is referenced in orders.";
            }
        }
        redirect("index.php?controller=admin&action=manageProducts");
    }

    public function manageOrders() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        require "views/admin/orders.php";
    }

    public function updateOrderStatus() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $orderId = (int)$_POST["order_id"];
            $status = $_POST["status"];
            $orderModel = new Order();
            if ($orderModel->updateStatus($orderId, $status)) {
                $_SESSION["success"] = "Order status updated successfully.";
            } else {
                $_SESSION["error"] = "Failed to update order status.";
            }
        }
        redirect("index.php?controller=admin&action=manageOrders");
    }

    public function deleteOrder() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        $orderId = (int)($_GET["id"] ?? 0);
        if ($orderId > 0) {
            global $pdo;
            $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$orderId]);
            $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$orderId]);
            $_SESSION["success"] = "Order deleted successfully.";
        }
        redirect("index.php?controller=admin&action=manageOrders");
    }

    public function manageUsers() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $users = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY id DESC")->fetchAll();
        require "views/admin/users.php";
    }

    public function deleteUser() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        $userId = (int)($_GET["id"] ?? 0);
        if ($userId > 0) {
            global $pdo;
            try {
                $check = $pdo->prepare("SELECT role FROM users WHERE id = ?");
                $check->execute([$userId]);
                if ($check->fetchColumn() === "admin") {
                    $_SESSION["error"] = "Admin account cannot be deleted.";
                } else {
                    // Delete related orders and items
                    $pdo->prepare("DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id = ?)")->execute([$userId]);
                    $pdo->prepare("DELETE FROM orders WHERE user_id = ?")->execute([$userId]);
                    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$userId]);
                    $_SESSION["success"] = "User deleted successfully.";
                }
            } catch (Exception $e) {
                $_SESSION["error"] = "Cannot delete user who has active orders.";
            }
        }
        redirect("index.php?controller=admin&action=manageUsers");
    }

    public function reports() {
        if (!isAdmin()) { redirect("index.php?controller=auth&action=login"); }
        global $pdo;
        $topProducts = $pdo->query("SELECT p.name, SUM(oi.quantity) as total_sold 
                                    FROM order_items oi 
                                    JOIN products p ON oi.product_id = p.id 
                                    GROUP BY p.id ORDER BY total_sold DESC LIMIT 5")->fetchAll();
        require "views/admin/reports.php";
    }
}
?>
