<?php
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Force CSRF token generation at session start
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRF($token) {
    if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        die("CSRF validation failed. Please refresh the page and try again.");
    }
}

// Generate token immediately when helpers are loaded
generateCSRFToken();
?>
