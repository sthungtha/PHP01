<?php
class FileController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        global $pdo;
        $userId = $_SESSION["user_id"];

        $stmt = $pdo->prepare("SELECT f.*, MAX(s.id) as share_id FROM files f 
                               LEFT JOIN shares s ON f.id = s.file_id 
                               WHERE f.user_id = ? GROUP BY f.id ORDER BY f.created_at DESC");
        $stmt->execute([$userId]);
        $files = $stmt->fetchAll();

        require "views/files/index.php";
    }

    public function upload() { /* unchanged */ 
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $userId = $_SESSION["user_id"];

        $stmt = $pdo->prepare("SELECT storage_used, storage_limit FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        $used = (int)($user["storage_used"] ?? 0);
        $limit = (int)($user["storage_limit"] ?? 1073741824);

        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $fileSize = $_FILES["file"]["size"];
            if ($used + $fileSize > $limit) {
                $_SESSION["error"] = "Storage quota exceeded!";
                redirect(BASE_URL . "index.php?controller=file&action=index");
            }

            $originalName = sanitize($_FILES["file"]["name"]);
            $fileType = $_FILES["file"]["type"];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $newFilename = uniqid("file_") . "." . $extension;
            $target = UPLOAD_DIR . $newFilename;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
                $stmt = $pdo->prepare("INSERT INTO files (user_id, filename, original_name, file_size, file_type, file_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $newFilename, $originalName, $fileSize, $fileType, $newFilename]);

                $pdo->prepare("UPDATE users SET storage_used = storage_used + ? WHERE id = ?")->execute([$fileSize, $userId]);

                $activity = new Activity();
                $activity->log($userId, "File uploaded", $originalName);

                $_SESSION["success"] = "File uploaded successfully!";
            } else {
                $_SESSION["error"] = "Upload failed.";
            }
        }
        redirect(BASE_URL . "index.php?controller=file&action=index");
    }

    public function share() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;

            $fileId = (int)($_POST["file_id"] ?? 0);
            $expiresDays = (int)($_POST["expires_days"] ?? 7);
            $password = $_POST["password"] ?? "";

            $shareToken = bin2hex(random_bytes(16));
            $expiresAt = $expiresDays > 0 ? date("Y-m-d H:i:s", strtotime("+$expiresDays days")) : null;
            $passwordHash = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

            $stmt = $pdo->prepare("INSERT INTO shares (file_id, share_token, expires_at, password_hash, created_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$fileId, $shareToken, $expiresAt, $passwordHash, $_SESSION["user_id"]]);

            $fullShareLink = BASE_URL . "index.php?controller=share&action=view&token=" . $shareToken;

            $_SESSION["success"] = "Share link generated successfully!";
            $_SESSION["share_link"] = $fullShareLink;

            $activity = new Activity();
            $activity->log($_SESSION["user_id"], "File shared", "Token: " . substr($shareToken, 0, 8));

            redirect(BASE_URL . "index.php?controller=file&action=index");
        }
    }

    public function revokeShare() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        validateCSRF($_GET["csrf_token"] ?? "");
        $shareId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM shares WHERE id = ? AND created_by = ?");
        $stmt->execute([$shareId, $_SESSION["user_id"]]);

        $activity = new Activity();
        $activity->log($_SESSION["user_id"], "Share link revoked");

        $_SESSION["success"] = "Share link revoked successfully!";
        redirect(BASE_URL . "index.php?controller=file&action=index");
    }

    public function deleteFile() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        validateCSRF($_GET["csrf_token"] ?? "");
        $fileId = (int)($_GET["id"] ?? 0);
        global $pdo;

        $stmt = $pdo->prepare("SELECT file_path FROM files WHERE id = ?");
        $stmt->execute([$fileId]);
        $file = $stmt->fetch();

        if ($file) {
            $filePath = UPLOAD_DIR . $file["file_path"];
            if (file_exists($filePath)) unlink($filePath);

            $stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
            $stmt->execute([$fileId]);

            $activity = new Activity();
            $activity->log($_SESSION["user_id"], "File deleted");

            $_SESSION["success"] = "File deleted successfully!";
        }
        redirect(BASE_URL . "index.php?controller=file&action=index");
    }
}
?>