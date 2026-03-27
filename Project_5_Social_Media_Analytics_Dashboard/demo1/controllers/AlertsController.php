<?php
class AlertsController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;

        // System alerts (simulated)
        $alerts = [
            ["type" => "danger",  "message" => "Sudden 42% drop in Instagram engagement today"],
            ["type" => "warning", "message" => "Twitter mentions spiked 180% in the last hour"],
            ["type" => "info",    "message" => "New follower milestone reached on LinkedIn (+850)"],
        ];

        // Load user-defined thresholds
        $stmt = $pdo->prepare("SELECT * FROM alert_thresholds WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$_SESSION["user_id"]]);
        $thresholds = $stmt->fetchAll();

        require "views/alerts/index.php";
    }

    // ADDED: Save custom alert threshold
    public function saveThreshold() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $metric    = sanitize($_POST["metric"] ?? "engagement");
            $platform  = sanitize($_POST["platform"] ?? "instagram");
            $threshold = (float)($_POST["threshold_value"] ?? 0);
            $direction = ($_POST["direction"] ?? "below") === "above" ? "above" : "below";
            $pdo->prepare(
                "INSERT INTO alert_thresholds (user_id, metric, platform, threshold_value, direction)
                 VALUES (?, ?, ?, ?, ?)"
            )->execute([$_SESSION["user_id"], $metric, $platform, $threshold, $direction]);
            $_SESSION["success"] = "Alert threshold saved.";
        }
        redirect(BASE_URL . "index.php?controller=alerts&action=index");
    }

    // ADDED: Delete a threshold
    public function deleteThreshold() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $id = (int)($_GET["id"] ?? 0);
        $pdo->prepare("DELETE FROM alert_thresholds WHERE id = ? AND user_id = ?")->execute([$id, $_SESSION["user_id"]]);
        $_SESSION["success"] = "Alert threshold removed.";
        redirect(BASE_URL . "index.php?controller=alerts&action=index");
    }
}
?>