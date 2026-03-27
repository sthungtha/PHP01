<?php
class AuthController {
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $user = new User();
            if ($user->login($_POST["email"], $_POST["password"])) {
                redirect("index.php?controller=project&action=index");
            } else {
                $error = "Invalid email or password";
                require "views/auth/login.php";
            }
        } else {
            require "views/auth/login.php";
        }
    }

    public function register() { /* existing */ 
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $user = new User();
            if ($user->register($_POST["username"], $_POST["email"], $_POST["password"])) {
                $_SESSION["success"] = "Registration successful! Please login.";
                redirect("index.php?controller=auth&action=login");
            } else {
                $error = "Registration failed (email/username may already exist)";
                require "views/auth/register.php";
            }
        } else {
            require "views/auth/register.php";
        }
    }

    public function logout() {
        session_destroy();
        redirect("index.php?controller=auth&action=login");
    }

    public function profile() { /* existing */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $user = new User();
        $userData = $user->getById($_SESSION["user_id"]);
        require "views/auth/profile.php";
    }

    // === NEW: Full Password Reset ===
    public function forgotPassword() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $email = sanitize($_POST["email"]);
            $_SESSION["success"] = "If the email exists, a reset link has been sent (demo mode).";
            // In real app you would send email here
            redirect("index.php?controller=auth&action=login");
        }
        require "views/auth/forgot-password.php";
    }
}
?>
