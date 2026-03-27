<?php
class Review {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }

    public function addReview($productId, $userId, $rating, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$productId, $userId, (int)$rating, $comment]);
    }

    public function getReviewsByProduct($productId) {
        $stmt = $this->pdo->prepare("SELECT r.*, u.username FROM reviews r 
                                     JOIN users u ON r.user_id = u.id 
                                     WHERE r.product_id = ? ORDER BY r.created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
}
?>
