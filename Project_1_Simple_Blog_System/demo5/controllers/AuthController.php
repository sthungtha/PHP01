<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");

            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            // Improved login with better error handling
            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM users WHERE email = ? AND verified = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                redirect("index.php?controller=post&action=index");
            } else {
                $error = "Invalid email or password. Please check your credentials.";
                require "views/auth/login.php";
            }
        } else {
            require "views/auth/login.php";
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            if ($this->userModel->register($_POST["username"], $_POST["email"], $_POST["password"])) {
                $success = "Registration successful! You can now login.";
                require "views/auth/login.php";
            } else {
                $error = "Registration failed. Username or email may already exist.";
                require "views/auth/register.php";
            }
        } else {
            require "views/auth/register.php";
        }
    }

    public function logout() {
        session_destroy();
        redirect("index.php?controller=post&action=index");
    }

    public function profile() {
        if (!isLoggedIn()) { redirect("index.php?controller=auth&action=login"); }
        $user = $this->userModel->getById($_SESSION["user_id"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $data = ["username" => sanitize($_POST["username"]), "email" => sanitize($_POST["email"])];
            if ($this->userModel->updateProfile($_SESSION["user_id"], $data)) {
                $_SESSION["username"] = $data["username"];
                $success = "Profile updated successfully.";
            }
        }
        require "views/auth/profile.php";
    }

    public function forgotPassword() { require "views/auth/forgot-password.php"; }
    public function resetPassword() { require "views/auth/reset-password.php"; }
}
?>