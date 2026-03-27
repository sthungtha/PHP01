<?php
class AuthController {
    public function login() {
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";

            $userModel = new User();
            if ($userModel->login($email, $password)) {
                $_SESSION["success"] = "Login successful!";
                redirect("index.php?controller=product&action=index");
                return;
            } else {
                $error = "Invalid email or password.";
            }
        }
        require "views/auth/login.php";
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $username = trim($_POST["username"] ?? "");
            $email    = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";

            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
                require "views/auth/register.php";
                return;
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $userModel = new User();

            try {
                if ($userModel->register($username, $email, $hashed)) {
                    if ($userModel->login($email, $password)) {
                        $_SESSION["success"] = "Registration successful! You are now logged in.";
                        redirect("index.php?controller=product&action=index");
                        return;
                    }
                }
                $error = "Registration failed.";
            } catch (Exception $e) {
                $error = "Username or email already exists.";
            }
            require "views/auth/register.php";
        } else {
            require "views/auth/register.php";
        }
    }

    public function profile() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }
        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);
        require "views/auth/profile.php";
    }

    public function logout() {
        session_destroy();
        redirect("index.php?controller=auth&action=login");
    }
}
?>
