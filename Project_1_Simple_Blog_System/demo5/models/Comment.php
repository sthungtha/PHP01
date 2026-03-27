<?php
class Comment {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Updated: Auto-approve if admin, otherwise pending
    public function create($postId, $userId, $content, $parentId = null) {
        // Check if the user is admin
        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        $status = ($user && $user['role'] === 'admin') ? 'approved' : 'pending';

        $stmt = $this->pdo->prepare("INSERT INTO comments 
            (post_id, user_id, content, parent_id, status) 
            VALUES (?, ?, ?, ?, ?)");

        return $stmt->execute([$postId, $userId, $content, $parentId, $status]);
    }

    public function getByPost($postId) {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username FROM comments c 
                                     JOIN users u ON c.user_id = u.id 
                                     WHERE c.post_id = ? AND c.status = 'approved' 
                                     ORDER BY c.created_at ASC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public function getPending() {
        $stmt = $this->pdo->prepare("SELECT c.*, p.title as post_title, u.username 
                                     FROM comments c 
                                     JOIN posts p ON c.post_id = p.id 
                                     JOIN users u ON c.user_id = u.id 
                                     WHERE c.status = 'pending' 
                                     ORDER BY c.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function moderate($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE comments SET status = ? WHERE id = ?");
        return $stmt->execute([$status, (int)$id]);
    }
}
?>