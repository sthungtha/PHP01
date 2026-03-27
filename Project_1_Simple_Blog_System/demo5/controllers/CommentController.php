<?php
class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function create() {
        if (!isLoggedIn()) {
            redirect("index.php?controller=auth&action=login");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");

            $postId = (int)$_POST["post_id"];
            $content = sanitize($_POST["content"] ?? "");

            if (!empty($content)) {
                $this->commentModel->create($postId, $_SESSION["user_id"], $content);
            }

            redirect("index.php?controller=post&action=show&id=" . $postId);
        }
    }
}
?>