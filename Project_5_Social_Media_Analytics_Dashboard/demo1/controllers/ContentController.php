<?php
class ContentController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $scheduled = $pdo->prepare("SELECT * FROM scheduled_posts WHERE user_id = ? ORDER BY scheduled_at DESC");
        $scheduled->execute([$_SESSION["user_id"]]);
        $posts = $scheduled->fetchAll();
        $livePosts = [
            ["platform"=>"Instagram","text"=>"New product launch! #NewCollection","date"=>"2026-03-26","engagement"=>1240],
            ["platform"=>"Twitter","text"=>"What's your favorite feature?","date"=>"2026-03-25","engagement"=>890],
            ["platform"=>"Facebook","text"=>"Join our live Q&A session tomorrow","date"=>"2026-03-24","engagement"=>320],
        ];
        require "views/content/index.php";
    }
    public function schedule() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $platform    = sanitize($_POST["platform"] ?? "");
            $content     = sanitize($_POST["content"] ?? "");
            $scheduledAt = sanitize($_POST["scheduled_at"] ?? "");
            $status      = ($_POST["status"] ?? "scheduled") === "draft" ? "draft" : "scheduled";
            if ($platform && $content && $scheduledAt) {
                $stmt = $pdo->prepare("INSERT INTO scheduled_posts (user_id,platform,content,scheduled_at,status) VALUES (?,?,?,?,?)");
                $stmt->execute([$_SESSION["user_id"],$platform,$content,$scheduledAt,$status]);
                $_SESSION["success"] = $status === "draft" ? "Post saved as draft." : "Post scheduled successfully!";
            }
        }
        redirect(BASE_URL . "index.php?controller=content&action=index");
    }
    public function deletePost() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $id = (int)($_GET["id"] ?? 0);
        $pdo->prepare("DELETE FROM scheduled_posts WHERE id = ? AND user_id = ?")->execute([$id,$_SESSION["user_id"]]);
        $_SESSION["success"] = "Post removed.";
        redirect(BASE_URL . "index.php?controller=content&action=index");
    }
    public function calendar() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM scheduled_posts WHERE user_id = ? ORDER BY scheduled_at ASC");
        $stmt->execute([$_SESSION["user_id"]]);
        $calPosts = $stmt->fetchAll();
        require "views/content/calendar.php";
    }
}
?>
