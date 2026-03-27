<?php
class CheckoutController {
    public function index() {
        global $pdo;
        $cartItems = [];
        $total = 0;
        $discount = 0;

        if (isset($_POST['coupon_code']) && strtoupper($_POST['coupon_code']) === 'SAVE10') {
            $discount = 10;
        }

        foreach (getCart() as $id => $qty) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $p = $stmt->fetch();
            if ($p) {
                $p["quantity"] = $qty;
                $subtotal = $p["price"] * $qty;
                $p["subtotal"] = $subtotal;
                $cartItems[] = $p;
                $total += $subtotal;
            }
        }

        $finalTotal = $total * (1 - $discount / 100);

        require "views/checkout/index.php";
    }

    public function confirm() {
        global $pdo;
        $orderModel = new Order();
        $total = 0;
        $cartItems = [];

        foreach (getCart() as $id => $qty) {
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $price = $stmt->fetchColumn();
            if ($price) {
                $total += $price * $qty;
                $cartItems[] = ["product_id" => $id, "quantity" => $qty, "price" => $price];
            }
        }

        $userId = isLoggedIn() ? $_SESSION["user_id"] : null;
        $orderId = $orderModel->createOrder($userId, $total);

        foreach ($cartItems as $item) {
            $orderModel->addOrderItem($orderId, $item["product_id"], $item["quantity"], $item["price"]);
        }

        $_SESSION["cart"] = [];
        $_SESSION["last_order_id"] = $orderId;

        redirect("index.php?controller=checkout&action=success");
    }

    public function success() {
        $orderId = $_SESSION["last_order_id"] ?? "N/A";
        unset($_SESSION["last_order_id"]);
        require "views/checkout/success.php";
    }
}
?>
