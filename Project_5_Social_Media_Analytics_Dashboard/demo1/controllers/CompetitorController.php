<?php
class CompetitorController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $dbComps = $pdo->prepare("SELECT * FROM competitors WHERE user_id = ? ORDER BY id DESC");
        $dbComps->execute([$_SESSION["user_id"]]);
        $savedCompetitors = $dbComps->fetchAll();
        $competitors = [
            ["name"=>"TechGiant",    "followers"=>245000,"engagement"=>6.8,"growth"=>"+12%"],
            ["name"=>"InnoBrand",    "followers"=>98000, "engagement"=>9.2,"growth"=>"+25%"],
            ["name"=>"MarketLeader", "followers"=>312000,"engagement"=>4.5,"growth"=>"-3%"],
        ];
        foreach ($savedCompetitors as $sc) { $competitors[] = ["name"=>$sc["name"],"followers"=>$sc["followers"],"engagement"=>$sc["engagement_rate"],"growth"=>$sc["growth"]]; }
        require "views/competitor/index.php";
    }
    public function add() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO competitors (user_id,name,handle,platform,followers,engagement_rate,growth) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$_SESSION["user_id"],sanitize($_POST["name"]),sanitize($_POST["handle"]),sanitize($_POST["platform"]),(int)$_POST["followers"],(float)$_POST["engagement"],sanitize($_POST["growth"])]);
            $_SESSION["success"] = "Competitor added successfully.";
        }
        redirect(BASE_URL . "index.php?controller=competitor&action=index");
    }
    public function remove() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");
        global $pdo;
        $pdo->prepare("DELETE FROM competitors WHERE id = ? AND user_id = ?")->execute([(int)$_GET["id"],$_SESSION["user_id"]]);
        $_SESSION["success"] = "Competitor removed.";
        redirect(BASE_URL . "index.php?controller=competitor&action=index");
    }
}
?>
