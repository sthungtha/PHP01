<?php require "views/layouts/header.php"; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Analytics Dashboard</h2>
  <form method="GET" action="<?php echo BASE_URL; ?>index.php" class="d-flex gap-2">
    <input type="hidden" name="controller" value="dashboard">
    <input type="hidden" name="action" value="index">
    <select name="range" class="form-select form-select-sm" onchange="this.form.submit()">
      <?php foreach ([7 => "Last 7 days", 30 => "Last 30 days", 90 => "Last 90 days"] as $v => $l): ?>
        <option value="<?php echo $v; ?>" <?php echo $dateRange == $v ? "selected" : ""; ?>>
          <?php echo $l; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>
</div>

<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card text-center border-primary"><div class="card-body">
    <h6>Total Followers</h6><h3 class="text-primary"><?php echo number_format($totalFollowers); ?></h3>
  </div></div></div>
  <div class="col-md-3"><div class="card text-center border-success"><div class="card-body">
    <h6>Total Reach</h6><h3 class="text-success"><?php echo number_format($totalReach); ?></h3>
  </div></div></div>
  <div class="col-md-3"><div class="card text-center border-warning"><div class="card-body">
    <h6>Avg Engagement</h6><h3 class="text-warning"><?php echo $avgEngagement; ?>%</h3>
  </div></div></div>
  <div class="col-md-3"><div class="card text-center border-info"><div class="card-body">
    <h6>Total Posts</h6><h3 class="text-info"><?php echo number_format($totalPosts); ?></h3>
  </div></div></div>
</div>

<h5>Platform Breakdown</h5>
<div class="row g-3 mb-4">
<?php foreach ($platforms as $key => $data): ?>
  <div class="col-md-4"><div class="card h-100"><div class="card-body">
    <h5><?php echo htmlspecialchars($data["label"]); ?></h5>
    <p class="mb-1">Followers:  <strong><?php echo number_format($data["followers"]); ?></strong></p>
    <p class="mb-1">Engagement: <strong><?php echo $data["engagement"]; ?>%</strong></p>
    <p class="mb-1">Posts:      <strong><?php echo $data["posts"]; ?></strong></p>
    <p class="mb-0">Reach:      <strong><?php echo number_format($data["reach"]); ?></strong></p>
  </div></div></div>
<?php endforeach; ?>
</div>

<h5>Engagement Rate Comparison</h5>
<canvas id="engChart" height="100"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById("engChart"), {
  type: "bar",
  data: {
    labels:   <?php echo json_encode(array_column($platforms, "label")); ?>,
    datasets: [{
      label: "Engagement Rate %",
      backgroundColor: ["#0d6efd","#e91e63","#1da1f2","#0077b5","#ff0000"],
      data: <?php echo json_encode(array_column($platforms, "engagement")); ?>
    }]
  },
  options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 20 } } }
});
</script>

<div class="mt-3">
  <a href="<?php echo BASE_URL; ?>index.php?controller=platform&action=connect" class="btn btn-primary">
    Manage Connected Accounts
  </a>
</div>
<?php require "views/layouts/footer.php"; ?>