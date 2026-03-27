<?php
class Comment {
    public function add($task_id, $user_id, $comment) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (task_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$task_id, $user_id, $comment]);
    }

    public function getByTask($task_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT c.*, u.username FROM comments c 
                               JOIN users u ON c.user_id = u.id 
                               WHERE c.task_id = ? ORDER BY c.created_at DESC");
        $stmt->execute([$task_id]);
        return $stmt->fetchAll();
    }
}
?>
