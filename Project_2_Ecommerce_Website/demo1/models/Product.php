<?php
class Product {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }

    public function getAll($search = "", $categoryId = null, $minPrice = null, $maxPrice = null, $sort = "newest") {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if ($minPrice !== null) {
            $sql .= " AND p.price >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice !== null) {
            $sql .= " AND p.price <= ?";
            $params[] = $maxPrice;
        }

        // Sorting
        switch ($sort) {
            case "price_low": $sql .= " ORDER BY p.price ASC"; break;
            case "price_high": $sql .= " ORDER BY p.price DESC"; break;
            case "oldest": $sql .= " ORDER BY p.created_at ASC"; break;
            default: $sql .= " ORDER BY p.created_at DESC"; // newest
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, c.name as category_name FROM products p 
                                     LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>
