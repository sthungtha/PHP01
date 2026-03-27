<?php
class ShareController {
    public function view() {
        global $pdo;
        $token = $_GET["token"] ?? "";

        $stmt = $pdo->prepare("SELECT s.*, f.*, u.username as owner_name 
                               FROM shares s 
                               JOIN files f ON s.file_id = f.id 
                               JOIN users u ON f.user_id = u.id 
                               WHERE s.share_token = ?");
        $stmt->execute([$token]);
        $share = $stmt->fetch();

        if (!$share) die("<div class='container mt-5'><div class='alert alert-danger text-center'>This share link does not exist or has been revoked.</div></div>");

        if ($share["expires_at"] && strtotime($share["expires_at"]) < time()) {
            die("<div class='container mt-5'><div class='alert alert-warning text-center'>This share link has expired.</div></div>");
        }

        // Password check
        if ($share["password_hash"] && $_SERVER["REQUEST_METHOD"] !== "POST") {
            require "views/shares/password.php"; exit;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!password_verify($_POST["password"], $share["password_hash"])) {
                $error = "Incorrect password";
                require "views/shares/password.php"; exit;
            }
        }

        require "views/shares/view.php";
    }

    public function revoke() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $shareId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM shares WHERE id = ? AND created_by = ?");
        $stmt->execute([$shareId, $_SESSION["user_id"]]);
        $_SESSION["success"] = "Share link revoked successfully!";
        redirect(BASE_URL . "index.php?controller=file&action=index");
    }
}
?>
