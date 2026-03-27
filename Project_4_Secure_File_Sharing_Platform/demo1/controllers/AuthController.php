<?php
class AuthController {
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $user = new User();
            $result = $user->login($_POST["email"], $_POST["password"]);

            if ($result === true) {
                redirect(BASE_URL . "index.php?controller=file&action=index");
            } elseif ($result === 'suspended') {
                $error = "Your account has been suspended. Please contact support.";
                require "views/auth/login.php";
            } else {
                $error = "Invalid email or password.";
                require "views/auth/login.php";
            }
        } else {
            require "views/auth/login.php";
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");

            $username = trim($_POST["username"] ?? "");
            $email    = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";
            $confirm  = $_POST["confirm_password"] ?? "";

            // Validate inputs
            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
                require "views/auth/register.php";
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
                require "views/auth/register.php";
                return;
            }
            if (strlen($password) < 6) {
                $error = "Password must be at least 6 characters.";
                require "views/auth/register.php";
                return;
            }
            if ($password !== $confirm) {
                $error = "Passwords do not match.";
                require "views/auth/register.php";
                return;
            }
            if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
                $error = "Username must be 3-50 characters: letters, numbers, or underscores only.";
                require "views/auth/register.php";
                return;
            }

            $userModel = new User();
            $result = $userModel->register(
                sanitize($username),
                sanitize($email),
                $password
            );

            if ($result['success']) {
                $userModel->login($email, $password);
                $activity = new Activity();
                $activity->log($_SESSION["user_id"], "User registered", $username);
                $_SESSION["success_flash"] = "Welcome, " . sanitize($username) . "! Your account has been created.";
                redirect(BASE_URL . "index.php?controller=file&action=index");
            } else {
                $error = $result['error'];
                require "views/auth/register.php";
            }
        } else {
            require "views/auth/register.php";
        }
    }

    public function profile() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $userModel = new User();
        $user = $userModel->getById($_SESSION["user_id"]);
        require "views/auth/profile.php";
    }

    public function logout() {
        session_destroy();
        redirect(BASE_URL . "index.php?controller=auth&action=login");
    }
}
?>