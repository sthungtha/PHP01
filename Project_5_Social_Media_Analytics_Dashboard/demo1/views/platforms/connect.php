<?php require "views/layouts/header.php"; ?>
<h2>Connect Social Media Accounts</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<div class="row g-4">
<?php
$platforms = [
    "facebook"  => ["name" => "Facebook",  "color" => "primary"],
    "instagram" => ["name" => "Instagram", "color" => "danger"],
    "twitter"   => ["name" => "Twitter",   "color" => "info"],
    "linkedin"  => ["name" => "LinkedIn",  "color" => "primary"],
    "youtube"   => ["name" => "YouTube",   "color" => "danger"],
];
foreach ($platforms as $key => $p):
    $connected = isset($_SESSION["connected_platforms"][$key]);
?>
  <div class="col-md-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h4 class="mb-3"><?php echo $p["name"]; ?></h4>
        <?php if ($connected): ?>
          <div class="alert alert-success mb-2">Connected</div>
          <a href="<?php echo BASE_URL; ?>index.php?controller=platform&action=disconnect&platform=<?php echo $key; ?>"
             class="btn btn-outline-danger">Disconnect</a>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>index.php?controller=platform&action=connectPlatform&platform=<?php echo $key; ?>"
             class="btn btn-<?php echo $p["color"]; ?> w-100">Connect via OAuth</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<h5 class="mt-5">Connected Accounts</h5>
<?php if (empty($_SESSION["connected_platforms"])): ?>
  <p class="text-muted">No accounts connected yet.</p>
<?php else: ?>
  <ul class="list-group">
  <?php foreach ($_SESSION["connected_platforms"] as $platform => $data): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <span><?php echo ucfirst(htmlspecialchars($platform)); ?> - <?php echo htmlspecialchars($data["username"]); ?></span>
      <span class="badge bg-success">Connected</span>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php require "views/layouts/footer.php"; ?>