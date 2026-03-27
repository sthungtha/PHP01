<?php
class AdminController {
    public function dashboard() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        global $pdo;
        $totalUsers   = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalFiles   = $pdo->query("SELECT COUNT(*) FROM files")->fetchColumn();
        $totalStorage = $pdo->query("SELECT COALESCE(SUM(file_size), 0) FROM files")->fetchColumn();
        $totalShares  = $pdo->query("SELECT COUNT(*) FROM shares")->fetchColumn();

        $activityModel = new Activity();
        $activities = $activityModel->getRecent();

        require "views/admin/dashboard.php";
    }

    public function manageUser() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        // CSRF token passed in GET URL (built by the view)
        validateCSRF($_GET["csrf_token"] ?? "");

        global $pdo;
        $targetId   = (int)($_GET["id"] ?? 0);
        $userAction = $_GET["user_action"] ?? "";

        // Prevent admin acting on their own account
        if ($targetId === (int)$_SESSION["user_id"]) {
            $_SESSION["error"] = "You cannot modify your own account.";
            redirect(BASE_URL . "index.php?controller=admin&action=users");
        }

        // Fetch the target user to verify they exist and are not an admin
        $stmt = $pdo->prepare("SELECT id, role, username FROM users WHERE id = ?");
        $stmt->execute([$targetId]);
        $targetUser = $stmt->fetch();

        if (!$targetUser) {
            $_SESSION["error"] = "User not found.";
            redirect(BASE_URL . "index.php?controller=admin&action=users");
        }

        if ($targetUser["role"] === "admin") {
            $_SESSION["error"] = "You cannot modify another admin account.";
            redirect(BASE_URL . "index.php?controller=admin&action=users");
        }

        $activityModel = new Activity();

        if ($userAction === "suspend") {
            $stmt = $pdo->prepare("UPDATE users SET role = 'suspended' WHERE id = ?");
            $stmt->execute([$targetId]);
            $activityModel->log($_SESSION["user_id"], "User suspended", "User: " . $targetUser["username"]);
            $_SESSION["success"] = "User \"" . htmlspecialchars($targetUser["username"]) . "\" has been suspended.";

        } elseif ($userAction === "unsuspend") {
            $stmt = $pdo->prepare("UPDATE users SET role = 'regular' WHERE id = ?");
            $stmt->execute([$targetId]);
            $activityModel->log($_SESSION["user_id"], "User unsuspended", "User: " . $targetUser["username"]);
            $_SESSION["success"] = "User \"" . htmlspecialchars($targetUser["username"]) . "\" has been reinstated.";

        } elseif ($userAction === "delete") {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$targetId]);
            $activityModel->log($_SESSION["user_id"], "User deleted", "User: " . $targetUser["username"]);
            $_SESSION["success"] = "User \"" . htmlspecialchars($targetUser["username"]) . "\" has been permanently deleted.";

        } else {
            $_SESSION["error"] = "Unknown action.";
        }

        redirect(BASE_URL . "index.php?controller=admin&action=users");
    }

    public function users() {
        if (!isAdmin()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        global $pdo;
        $stmt  = $pdo->query("SELECT * FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll();

        require "views/admin/users.php";
    }
}
?>