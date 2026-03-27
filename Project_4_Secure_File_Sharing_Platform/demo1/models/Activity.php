<?php
class Activity {
    public function log($user_id, $action, $details = '') {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO activities (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$user_id, $action, $details]);
    }

    public function getRecent() {
        global $pdo;
        $stmt = $pdo->query("SELECT a.*, u.username FROM activities a 
                             LEFT JOIN users u ON a.user_id = u.id 
                             ORDER BY a.created_at DESC LIMIT 20");
        return $stmt->fetchAll();
    }
}
?>
