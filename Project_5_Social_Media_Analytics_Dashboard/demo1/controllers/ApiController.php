<?php
class ApiController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        require "views/api/index.php";
    }

    public function data() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        $endpoint = $_GET["endpoint"] ?? "metrics";
        $platform = $_GET["platform"] ?? "all";

        $metrics = [
            "facebook"  => ["followers" => 12450, "engagement" => 8.4,  "posts" => 45, "reach" => 48000],
            "instagram" => ["followers" => 8750,  "engagement" => 12.7, "posts" => 32, "reach" => 32000],
            "twitter"   => ["followers" => 3200,  "engagement" => 5.2,  "posts" => 68, "reach" => 15000],
            "linkedin"  => ["followers" => 1850,  "engagement" => 9.1,  "posts" => 12, "reach" => 9000],
            "youtube"   => ["followers" => 4200,  "engagement" => 7.3,  "posts" => 18, "reach" => 145000],
        ];

        if ($endpoint === "metrics") {
            $data = ($platform !== "all" && isset($metrics[$platform])) ? $metrics[$platform] : $metrics;
        } elseif ($endpoint === "posts") {
            $data = [
                ["platform" => "Instagram", "text" => "New launch #NewCollection",   "date" => "2026-03-26", "engagement" => 1240],
                ["platform" => "Twitter",   "text" => "What is your favourite feature?", "date" => "2026-03-25", "engagement" => 890],
            ];
        } elseif ($endpoint === "webhooks") {
            // ADDED: Webhook info endpoint
            $data = [
                "info"    => "Register a URL to receive real-time POST notifications.",
                "events"  => ["engagement_drop", "follower_milestone", "mention_spike"],
                "format"  => ["event" => "string", "platform" => "string", "value" => "number", "timestamp" => "ISO8601"],
                "demo"    => "Webhook delivery is simulated in this demo environment.",
            ];
        } else {
            $data = ["error" => "Unknown endpoint. Available: metrics, posts, webhooks"];
        }

        echo json_encode([
            "status"   => "ok",
            "version"  => "1.0",
            "endpoint" => $endpoint,
            "data"     => $data,
        ], JSON_PRETTY_PRINT);
        exit;
    }
}
?>