<?php
class Category {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
