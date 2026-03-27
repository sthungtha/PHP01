<?php
class AdminController {
    public function dashboard() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $totalUsers     = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalPosts     = $pdo->query("SELECT COUNT(*) FROM scheduled_posts")->fetchColumn();
        $totalPlatforms = count($_SESSION["connected_platforms"] ?? []);
        $recentUsers    = $pdo->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();
        require "views/admin/dashboard.php";
    }

    public function users() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
        require "views/admin/users.php";
    }

    public function suspendUser() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $userId = (int)($_GET["id"] ?? 0);
        if ($userId == $_SESSION["user_id"]) {
            $_SESSION["error"] = "You cannot suspend yourself.";
            redirect(BASE_URL . "index.php?controller=admin&action=users");
        }
        global $pdo;
        $pdo->prepare("UPDATE users SET role = 'suspended' WHERE id = ? AND role != 'admin'")->execute([$userId]);
        logAudit($pdo, 'suspend_user', "Target user ID: $userId");
        $_SESSION["success"] = "User suspended successfully.";
        redirect(BASE_URL . "index.php?controller=admin&action=users");
    }

    public function unsuspendUser() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $userId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $pdo->prepare("UPDATE users SET role = 'analyst' WHERE id = ? AND role = 'suspended'")->execute([$userId]);
        logAudit($pdo, 'unsuspend_user', "Target user ID: $userId");
        $_SESSION["success"] = "User unsuspended. Role restored to Analyst.";
        redirect(BASE_URL . "index.php?controller=admin&action=users");
    }

    public function deleteUser() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $userId = (int)($_GET["id"] ?? 0);
        if ($userId == $_SESSION["user_id"]) {
            $_SESSION["error"] = "You cannot delete yourself.";
            redirect(BASE_URL . "index.php?controller=admin&action=users");
        }
        global $pdo;
        $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'")->execute([$userId]);
        logAudit($pdo, 'delete_user', "Target user ID: $userId");
        $_SESSION["success"] = "User deleted successfully.";
        redirect(BASE_URL . "index.php?controller=admin&action=users");
    }

    // ADDED: Promote analyst to Manager role
    public function promoteUser() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $userId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $pdo->prepare("UPDATE users SET role = 'manager' WHERE id = ? AND role = 'analyst'")->execute([$userId]);
        logAudit($pdo, 'promote_user', "Target user ID: $userId promoted to manager");
        $_SESSION["success"] = "User promoted to Manager.";
        redirect(BASE_URL . "index.php?controller=admin&action=users");
    }

    // ADDED: View audit log
    public function auditLog() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $logs = $pdo->query(
            "SELECT a.*, u.username FROM audit_log a
             LEFT JOIN users u ON a.user_id = u.id
             ORDER BY a.created_at DESC LIMIT 100"
        )->fetchAll();
        require "views/admin/audit_log.php";
    }
}
?>