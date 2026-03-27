<?php
class ProductController {
    public function index() {
        $search = $_GET["search"] ?? "";
        $minPrice = $_GET["min_price"] ?? null;
        $maxPrice = $_GET["max_price"] ?? null;
        $sort = $_GET["sort"] ?? "newest";

        $productModel = new Product();
        $products = $productModel->getAll($search, null, $minPrice, $maxPrice, $sort);

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        require "views/products/index.php";
    }

    public function show() {
        $productModel = new Product();
        $product = $productModel->getById((int)($_GET["id"] ?? 0));
        if (!$product) { echo "Product not found"; return; }
        require "views/products/show.php";
    }
}
?>
