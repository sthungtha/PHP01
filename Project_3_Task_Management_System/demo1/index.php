<?php
require_once "config/config.php";
require_once "config/database.php";
require_once "includes/helpers.php";

require_once "models/User.php";
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
        echo "Action '$action' not found in controller.";
    }
} else {
    if (isLoggedIn()) {
        redirect("index.php?controller=project&action=index");
    } else {
        redirect("index.php?controller=auth&action=login");
    }
}
?>
