<?php
class Category {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function create($name) {
        $slug = strtolower(str_replace(" ", "-", $name));
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        return $stmt->execute([$name, $slug]);
    }
}
?>
