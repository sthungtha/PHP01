<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/includes/helpers.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/models/Post.php";
require_once __DIR__ . "/models/Category.php";
require_once __DIR__ . "/models/Comment.php";
require_once __DIR__ . "/controllers/AuthController.php";
require_once __DIR__ . "/controllers/PostController.php";
require_once __DIR__ . "/controllers/CategoryController.php";
require_once __DIR__ . "/controllers/CommentController.php";
require_once __DIR__ . "/controllers/AdminController.php";

$controller = $_GET["controller"] ?? "post";
$action     = $_GET["action"] ?? "index";

$controllerName = ucfirst($controller) . "Controller";
if (class_exists($controllerName)) {
    $ctrl = new $controllerName();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Action '$action' not found.";
    }
} else {
    $postCtrl = new PostController();
    $postCtrl->index();
}
?>
