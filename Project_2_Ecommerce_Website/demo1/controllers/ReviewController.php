<?php
class ReviewController {
    public function add() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            
            $productId = (int)($_POST["product_id"] ?? 0);
            $rating = (int)($_POST["rating"] ?? 0);
            $comment = sanitize($_POST["comment"] ?? "");

            if ($productId > 0 && $rating >= 1 && $rating <= 5 && !empty($comment)) {
                $reviewModel = new Review();
                $reviewModel->addReview($productId, $_SESSION["user_id"], $rating, $comment);
                $_SESSION["success"] = "Thank you for your review!";
            } else {
                $_SESSION["error"] = "Please provide a valid rating and comment.";
            }
        }
        redirect("index.php?controller=product&action=show&id=" . $productId);
    }
}
?>
