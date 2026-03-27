<?php
class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAll();
        require "views/categories/index.php";
    }

    public function create() {
        if (!isAdmin()) {
            echo "Access denied.";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $name = sanitize($_POST["name"] ?? "");

            if (!empty($name)) {
                if ($this->categoryModel->create($name)) {
                    $success = "Category '{$name}' created successfully!";
                } else {
                    $error = "Failed to create category. It may already exist.";
                }
            }
        }

        $categories = $this->categoryModel->getAll();
        require "views/admin/categories.php";
    }

    // New: Delete category
    public function delete() {
        if (!isAdmin()) {
            echo "Access denied.";
            return;
        }

        $id = (int)($_GET["id"] ?? 0);
        if ($id > 0) {
            global $pdo;
            // First remove relations from post_categories (safe delete)
            $pdo->prepare("DELETE FROM post_categories WHERE category_id = ?")->execute([$id]);
            // Then delete the category
            $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
            $success = "Category deleted successfully.";
        }

        $categories = $this->categoryModel->getAll();
        require "views/admin/categories.php";
    }
}
?>