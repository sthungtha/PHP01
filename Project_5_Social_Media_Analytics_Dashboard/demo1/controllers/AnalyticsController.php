<?php
class AnalyticsController {
    public function sentiment() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $sentimentData = [
            "facebook" => ["positive" => 68, "negative" => 12, "neutral" => 20],
            "instagram" => ["positive" => 82, "negative" => 8, "neutral" => 10],
            "twitter" => ["positive" => 45, "negative" => 35, "neutral" => 20],
            "linkedin" => ["positive" => 91, "negative" => 4, "neutral" => 5],
            "youtube" => ["positive" => 77, "negative" => 15, "neutral" => 8]
        ];

        require "views/analytics/sentiment.php";
    }

    public function hashtags() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $hashtags = [
            ["tag" => "#NewCollection", "posts" => 124, "engagement" => 24500, "growth" => "+18%"],
            ["tag" => "#TechTalk", "posts" => 87, "engagement" => 18900, "growth" => "+9%"],
            ["tag" => "#CustomerLove", "posts" => 56, "engagement" => 12400, "growth" => "-3%"],
        ];

        require "views/analytics/hashtags.php";
    }

    public function alerts() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $alerts = [
            ["type" => "danger", "message" => "Sudden drop in Instagram engagement (-42% today)"],
            ["type" => "warning", "message" => "Twitter mention volume increased by 180%"],
            ["type" => "info", "message" => "New follower milestone reached on LinkedIn"],
        ];

        require "views/analytics/alerts.php";
    }
}
?>
