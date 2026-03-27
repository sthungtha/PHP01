<?php
class AdminController {
    
    public function dashboard() {
        if (!isAdmin()) {
            echo "<div class='alert alert-danger'>Access denied. Admin only.</div>";
            return;
        }

        global $pdo;
        $totalPosts    = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
        $totalComments = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
        $totalUsers    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

        require "views/admin/dashboard.php";
    }

    // Manage All Posts (Fixed)
    public function managePosts() {
        if (!isAdmin()) {
            echo "<div class='alert alert-danger'>Access denied.</div>";
            return;
        }

        global $pdo;
        $stmt = $pdo->query("SELECT p.id, p.title, p.status, p.created_at, u.username 
                             FROM posts p 
                             JOIN users u ON p.user_id = u.id 
                             ORDER BY p.created_at DESC");
        $posts = $stmt->fetchAll();

        require "views/admin/posts.php";
    }

    public function manageUsers() {
        if (!isAdmin()) {
            echo "<div class='alert alert-danger'>Access denied.</div>";
            return;
        }

        global $pdo;

        // Handle role change and delete
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
            validateCSRF($_POST["csrf_token"] ?? "");
            $userId = (int)$_POST["user_id"];

            if ($_POST['action'] === 'change_role' && isset($_POST["new_role"])) {
                $newRole = $_POST["new_role"] === "admin" ? "admin" : "user";
                $pdo->prepare("UPDATE users SET role = ? WHERE id = ?")->execute([$newRole, $userId]);
                $success = "User role updated.";
            }

            if ($_POST['action'] === 'delete_user' && $userId !== $_SESSION["user_id"]) {
                $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$userId]);
                $success = "User deleted successfully.";
            }
        }

        $users = $pdo->query("SELECT id, username, email, role, verified, created_at FROM users ORDER BY id DESC")->fetchAll();
        require "views/admin/users.php";
    }

    public function manageCategories() {
        if (!isAdmin()) return;
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        require "views/admin/categories.php";
    }

    public function moderateComments() {
        if (!isAdmin()) return;

        $commentModel = new Comment();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comment_id'])) {
            validateCSRF($_POST["csrf_token"] ?? "");
            $commentId = (int)$_POST["comment_id"];
            $action = $_POST["action"]; // approve or reject

            $status = ($action === "approve") ? "approved" : "rejected";
            $commentModel->moderate($commentId, $status);
            $success = "Comment " . ucfirst($action) . "ed successfully.";
        }

        $pendingComments = $commentModel->getPending();
        require "views/admin/comments.php";
    }
        public function createTestComment() {
        if (!isAdmin()) {
            echo "Access denied.";
            return;
        }

        global $pdo;

        // Get the first existing user safely (usually admin or user1)
        $stmt = $pdo->query("SELECT id FROM users ORDER BY id ASC LIMIT 1");
        $user = $stmt->fetch();

        if (!$user) {
            echo "No users found in database.";
            return;
        }

        $userId = $user['id'];

        // Insert test pending comment using existing user
        $pdo->prepare("INSERT INTO comments (post_id, user_id, content, status) 
                       VALUES (1, ?, 'This is a test comment that needs moderation. Please approve or reject me.', 'pending')")
            ->execute([$userId]);

        redirect("index.php?controller=admin&action=moderateComments");
    }
}
?>