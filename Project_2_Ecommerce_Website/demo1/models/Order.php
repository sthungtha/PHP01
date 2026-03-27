<?php
class Order {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }

    public function createOrder($userId, $total) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->execute([$userId, $total]);
        return $this->pdo->lastInsertId();
    }

    public function addOrderItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity, $price]);
    }

    public function getUserOrders($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAllOrders() {
        $stmt = $this->pdo->prepare("SELECT o.*, u.username FROM orders o 
                                     LEFT JOIN users u ON o.user_id = u.id 
                                     ORDER BY o.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
}
?>
