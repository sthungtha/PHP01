<?php
class WishlistController {
    public function index() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }
        $wishlistModel = new Wishlist();
        $wishlistIds = $wishlistModel->getAll();
        $products = [];
        if (!empty($wishlistIds)) {
            global $pdo;
            $placeholders = str_repeat('?,', count($wishlistIds) - 1) . '?';
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($wishlistIds);
            $products = $stmt->fetchAll();
        }
        require "views/wishlist/index.php";
    }

    public function add() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $wishlistModel = new Wishlist();
            $wishlistModel->add((int)$_POST["product_id"]);
            $_SESSION["success"] = "Added to wishlist!";
        }
        redirect("index.php?controller=product&action=show&id=" . $_POST["product_id"]);
    }

    public function remove() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }
        $wishlistModel = new Wishlist();
        $wishlistModel->remove((int)$_GET["id"]);
        $_SESSION["success"] = "Removed from wishlist.";
        redirect("index.php?controller=wishlist&action=index");
    }
}
?>
