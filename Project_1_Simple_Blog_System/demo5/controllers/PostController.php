<?php
class PostController {
    private $postModel;
    private $categoryModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->categoryModel = new Category();
    }

    public function index() {
        $search = $_GET["search"] ?? "";
        $page   = max(1, (int)($_GET["page"] ?? 1));
        $limit  = 6;
        $offset = ($page - 1) * $limit;
        $categoryId = !empty($_GET["category"]) ? (int)$_GET["category"] : null;

        $posts = $this->postModel->getAll($limit, $offset, $categoryId, $search);
        $totalPosts = $this->postModel->getTotalPosts($search);
        $categories = $this->categoryModel->getAll();

        require "views/posts/index.php";
    }

    // New: Show only posts created by the logged-in user
    public function myPosts() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        $userId = $_SESSION["user_id"];
        global $pdo;
        $stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p 
                               JOIN users u ON p.user_id = u.id 
                               WHERE p.user_id = ? 
                               ORDER BY p.created_at DESC");
        $stmt->execute([$userId]);
        $posts = $stmt->fetchAll();

        require "views/posts/my-posts.php";
    }

    public function create() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");

            $title = sanitize($_POST["title"]);
            $content = $_POST["content"];   // TinyMCE content (allow HTML)
            $imagePath = null;

            if (isset($_FILES["featured_image"]) && $_FILES["featured_image"]["error"] == 0) {
                $imagePath = uploadImage($_FILES["featured_image"]);
            }

            $postId = $this->postModel->create($title, $content, $_SESSION["user_id"], $imagePath);

            if (isset($_POST["categories"]) && is_array($_POST["categories"])) {
                $this->postModel->assignCategories($postId, $_POST["categories"]);
            }

            redirect("index.php?controller=post&action=show&id=" . $postId);
        }

        $categories = $this->categoryModel->getAll();
        require "views/posts/create.php";
    }

    public function show() {
        $id = (int)($_GET["id"] ?? 0);
        $post = $this->postModel->getById($id);
        if (!$post) {
            echo "Post not found.";
            return;
        }

        $commentModel = new Comment();
        $comments = $commentModel->getByPost($post["id"]);

        require "views/posts/show.php";
    }

    public function edit() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        $id = (int)($_GET["id"] ?? 0);
        $post = $this->postModel->getById($id);

        if (!$post || ($post["user_id"] != $_SESSION["user_id"] && !isAdmin())) {
            echo "Unauthorized access.";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");

            $title = sanitize($_POST["title"]);
            $content = $_POST["content"];
            $imagePath = $post["featured_image"];

            if (isset($_FILES["featured_image"]) && $_FILES["featured_image"]["error"] == 0) {
                $imagePath = uploadImage($_FILES["featured_image"]);
            }

            $this->postModel->update($id, $title, $content, $imagePath);

            if (isset($_POST["categories"]) && is_array($_POST["categories"])) {
                $this->postModel->assignCategories($id, $_POST["categories"]);
            }

            redirect("index.php?controller=post&action=show&id=" . $id);
        }

        $categories = $this->categoryModel->getAll();
        require "views/posts/edit.php";
    }

    public function delete() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        $id = (int)($_GET["id"] ?? 0);
        $this->postModel->delete($id);
        redirect("index.php?controller=post&action=myPosts");
    }
}
?>