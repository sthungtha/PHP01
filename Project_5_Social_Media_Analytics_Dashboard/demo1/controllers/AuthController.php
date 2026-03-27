<?php
class AuthController {
    public function login() {
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $email    = sanitize($_POST["email"]);
            $password = $_POST["password"];
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user["password"])) {
                if ($user["role"] === "suspended") {
                    $error = "Your account has been suspended. Please contact an administrator.";
                } else {
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["role"] = $user["role"];
                    logAudit($pdo, 'login', $email);
                    redirect(BASE_URL . "index.php?controller=dashboard&action=index");
                }
            } else {
                $error = "Invalid email or password.";
            }
        }
        require "views/auth/login.php";
    }

    public function register() {
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $username = sanitize($_POST["username"]);
            $email    = sanitize($_POST["email"]);
            $password = $_POST["password"];
            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
                require "views/auth/register.php";
                return;
            }
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'analyst')");
                $stmt->execute([$username, $email, $hashed]);
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                $_SESSION["user_id"]  = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"]     = $user["role"];
                logAudit($pdo, 'register', $email);
                $_SESSION["success"] = "Registration successful! You are now logged in.";
                redirect(BASE_URL . "index.php?controller=dashboard&action=index");
            } catch (Exception $e) {
                $error = "Username or email already exists.";
            }
        }
        require "views/auth/register.php";
    }

    public function profile() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);
        $user = $stmt->fetch();
        require "views/auth/profile.php";
    }

    // ADDED: Change password
    public function changePassword() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION["user_id"]]);
            $user = $stmt->fetch();
            $current = $_POST["current_password"] ?? "";
            $newPass = $_POST["new_password"] ?? "";
            $confirm = $_POST["confirm_password"] ?? "";
            if (!password_verify($current, $user["password"])) {
                $error = "Current password is incorrect.";
            } elseif (strlen($newPass) < 6) {
                $error = "New password must be at least 6 characters.";
            } elseif ($newPass !== $confirm) {
                $error = "New passwords do not match.";
            } else {
                $hashed = password_hash($newPass, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hashed, $_SESSION["user_id"]]);
                logAudit($pdo, 'change_password', 'User changed their password');
                $_SESSION["success"] = "Password changed successfully.";
                redirect(BASE_URL . "index.php?controller=auth&action=profile");
            }
        }
        require "views/auth/change_password.php";
    }

    public function logout() {
        global $pdo;
        logAudit($pdo, 'logout', $_SESSION["username"] ?? '');
        session_destroy();
        redirect(BASE_URL . "index.php?controller=auth&action=login");
    }
}
?>