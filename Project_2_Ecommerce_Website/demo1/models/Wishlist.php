<?php
class Wishlist {
    public function add($productId) {
        if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];
        if (!in_array($productId, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $productId;
        }
    }

    public function getAll() {
        return $_SESSION['wishlist'] ?? [];
    }

    public function remove($productId) {
        if (isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$productId]);
        }
    }
}
?>
