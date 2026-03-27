<?php
class Activity {
    public function add($task_id, $user_id, $action) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO activity_log (task_id, user_id, action, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$task_id, $user_id, $action]);
    }

    public function getByTask($task_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT a.*, u.username FROM activity_log a 
                               JOIN users u ON a.user_id = u.id 
                               WHERE a.task_id = ? ORDER BY a.created_at DESC LIMIT 10");
        $stmt->execute([$task_id]);
        return $stmt->fetchAll();
    }
}
?>
