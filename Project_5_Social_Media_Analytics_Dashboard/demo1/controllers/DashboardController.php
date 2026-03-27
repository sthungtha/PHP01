<?php
class DashboardController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        if (isSuspended()) { session_destroy(); redirect(BASE_URL . "index.php?controller=auth&action=login"); }

        $dateRange = (int)($_GET["range"] ?? 30);

        $platforms = [
            "facebook"  => ["label" => "Facebook",  "followers" => 12450, "engagement" => 8.4,  "posts" => 45, "reach" => 48000],
            "instagram" => ["label" => "Instagram", "followers" => 8750,  "engagement" => 12.7, "posts" => 32, "reach" => 32000],
            "twitter"   => ["label" => "Twitter",   "followers" => 3200,  "engagement" => 5.2,  "posts" => 68, "reach" => 15000],
            "linkedin"  => ["label" => "LinkedIn",  "followers" => 1850,  "engagement" => 9.1,  "posts" => 12, "reach" => 9000],
            "youtube"   => ["label" => "YouTube",   "followers" => 4200,  "engagement" => 7.3,  "posts" => 18, "reach" => 145000],
        ];

        $totalFollowers = array_sum(array_column($platforms, "followers"));
        $totalReach     = array_sum(array_column($platforms, "reach"));
        $avgEngagement  = round(array_sum(array_column($platforms, "engagement")) / count($platforms), 1);
        $totalPosts     = array_sum(array_column($platforms, "posts"));

        require "views/dashboard/index.php";
    }
}
?>