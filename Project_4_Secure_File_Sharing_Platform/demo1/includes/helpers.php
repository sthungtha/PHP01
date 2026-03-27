<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRF($token) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        die("CSRF validation failed. Please refresh the page and try again.");
    }
}

define('BASE_URL', '/PHP01/Projects/Project_4_Secure_File_Sharing_Platform/demo1/');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
?>
