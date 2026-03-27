<?php
session_start();
function isLoggedIn() { return isset($_SESSION["user_id"]); }
function isAdmin() { return isset($_SESSION["role"]) && $_SESSION["role"] === "admin"; }
function redirect($url) { header("Location: " . BASE_URL . $url); exit; }
function sanitize($data) { return htmlspecialchars(trim($data), ENT_QUOTES, "UTF-8"); }
function generateCSRFToken() {
    if (empty($_SESSION["csrf_token"])) $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    return $_SESSION["csrf_token"];
}
function validateCSRF($token) {
    if (!isset($_SESSION["csrf_token"]) || $token !== $_SESSION["csrf_token"]) die("CSRF Error");
}

// Shopping Cart
function getCart() { return $_SESSION["cart"] ?? []; }
function addToCart($productId, $qty = 1) {
    if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];
    $_SESSION["cart"][$productId] = ($_SESSION["cart"][$productId] ?? 0) + $qty;
}
function updateCartQty($productId, $qty) {
    if ($qty > 0) $_SESSION["cart"][$productId] = $qty;
    else unset($_SESSION["cart"][$productId]);
}
function removeFromCart($productId) { unset($_SESSION["cart"][$productId]); }
?>
