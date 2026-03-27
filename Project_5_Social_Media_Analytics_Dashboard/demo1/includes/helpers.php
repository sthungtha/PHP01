<?php
function isLoggedIn()  { return isset($_SESSION['user_id']); }
function isAdmin()     { return isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; }
function isManager()   { return isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','manager']); }
function isSuspended() { return isset($_SESSION['role']) && $_SESSION['role'] === 'suspended'; }

function redirect($url) { header("Location: $url"); exit; }

function sanitize($data) { return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8'); }

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
    return $_SESSION['csrf_token'];
}
function validateCSRF($token) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        die("CSRF validation failed. Please go back and try again.");
    }
}

// Audit logging  writes to audit_log table
function logAudit($pdo, $action, $detail = '') {
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO audit_log (user_id, action, detail, ip, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->execute([
            $_SESSION['user_id'] ?? 0,
            $action,
            $detail,
            $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    } catch (Exception $e) {
        // Fail silently  don't break the app if logging fails
    }
}

define('BASE_URL', '/PHP01/Projects/Project_5_Social_Media_Analytics_Dashboard/demo1/');
?>