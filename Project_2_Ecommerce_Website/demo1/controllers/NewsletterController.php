<?php
class NewsletterController {
    public function subscribe() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            $email = sanitize($_POST["email"] ?? "");
            if (!empty($email)) {
                $success = "Thank you! You have been subscribed to our newsletter.";
            }
        }
        redirect("index.php?controller=product&action=index");
    }
}
?>
