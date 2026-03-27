<?php
class Comment {
    public function add($file_id, $user_id, $comment) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (file_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$file_id, $user_id, $comment]);
    }

    public function getByFile($file_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT c.*, u.username FROM comments c 
                               JOIN users u ON c.user_id = u.id 
                               WHERE c.file_id = ? ORDER BY c.created_at DESC");
        $stmt->execute([$file_id]);
        return $stmt->fetchAll();
    }
}
?>
