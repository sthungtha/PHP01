<?php
session_start();
require_once "config/database.php";
require_once "includes/helpers.php";

require_once "models/User.php";
require_once "models/Activity.php";
require_once "models/Comment.php";

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerFile = "controllers/" . ucfirst($controller) . "Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . "Controller";
    $obj = new $controllerClass();

    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        die("Action '" . $action . "' not found.");
    }
} else {
    if (isLoggedIn()) {
        redirect(BASE_URL . "index.php?controller=file&action=index");
    } else {
        redirect(BASE_URL . "index.php?controller=auth&action=login");
    }
}
?>
