<?php
session_start();
require_once "config/database.php";
require_once "includes/helpers.php";

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
        die("Action '$action' not found.");
    }
} else {
    die("Controller '$controller' not found.");
}
?>
