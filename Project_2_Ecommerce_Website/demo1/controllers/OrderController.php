<?php
class OrderController {
    public function index() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }
        $orderModel = new Order();
        $orders = $orderModel->getUserOrders($_SESSION["user_id"]);
        require "views/orders/index.php";
    }
}
?>
