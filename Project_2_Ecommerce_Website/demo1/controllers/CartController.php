<?php
class CartController {
    public function add() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            addToCart((int)$_POST["product_id"], (int)($_POST["quantity"] ?? 1));
            $_SESSION["success"] = "Product added to cart successfully!";
            redirect("index.php?controller=product&action=index");
        }
    }

    public function index() {
        global $pdo;
        $cartItems = [];
        $total = 0;
        foreach (getCart() as $id => $qty) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $p = $stmt->fetch();
            if ($p) {
                $p["quantity"] = $qty;
                $p["subtotal"] = $p["price"] * $qty;
                $cartItems[] = $p;
                $total += $p["subtotal"];
            }
        }
        require "views/cart/index.php";
    }

    public function remove() {
        removeFromCart((int)$_GET["id"]);
        $_SESSION["success"] = "Product removed from cart.";
        redirect("index.php?controller=cart&action=index");
    }
}
?>
