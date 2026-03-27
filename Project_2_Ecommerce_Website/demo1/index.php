<?php
require_once "config/database.php";
require_once "config/config.php";
require_once "includes/helpers.php";

require_once "models/User.php";
require_once "models/Product.php";
require_once "models/Category.php";
require_once "models/Order.php";
require_once "models/Review.php";
require_once "models/Wishlist.php";

require_once "controllers/AuthController.php";
require_once "controllers/ProductController.php";
require_once "controllers/CartController.php";
require_once "controllers/CheckoutController.php";
require_once "controllers/AdminController.php";
require_once "controllers/OrderController.php";
require_once "controllers/ReviewController.php";
require_once "controllers/WishlistController.php";

$controller = $_GET["controller"] ?? "product";
$action = $_GET["action"] ?? "index";

$ctrlName = ucfirst($controller)."Controller";
if (class_exists($ctrlName)) {
    $ctrl = new $ctrlName();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Action '$action' not found in controller.";
    }
} else {
    echo "Controller '$ctrlName' not found.";
    (new ProductController())->index();
}
?>
