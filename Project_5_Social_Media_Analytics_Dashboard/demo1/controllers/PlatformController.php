<?php
class PlatformController {
    public function connect() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $connected = $_SESSION["connected_platforms"] ?? [];
        require "views/platforms/connect.php";
    }

    public function connectPlatform() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $platform = sanitize($_GET["platform"] ?? "");

        $_SESSION["connected_platforms"][$platform] = [
            "connected" => true,
            "connected_at" => date("Y-m-d H:i:s"),
            "username" => $platform . "_demo_account",
            "token" => "fake_oauth_token_" . uniqid()
        ];

        $_SESSION["success"] = ucfirst($platform) . " account connected successfully with OAuth!";
        redirect(BASE_URL . "index.php?controller=platform&action=connect");
    }

    public function disconnect() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        $platform = sanitize($_GET["platform"] ?? "");
        unset($_SESSION["connected_platforms"][$platform]);
        $_SESSION["success"] = ucfirst($platform) . " account disconnected.";
        redirect(BASE_URL . "index.php?controller=platform&action=connect");
    }
}
?>
