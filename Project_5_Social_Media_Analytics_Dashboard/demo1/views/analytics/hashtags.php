<?php require "views/layouts/header.php"; ?>
<h2>Hashtag Tracking</h2>

<div class="mb-4">
  <form method="GET" action="<?php echo BASE_URL; ?>index.php" class="d-flex gap-2">
    <input type="hidden" name="controller" value="analytics">
    <input type="hidden" name="action" value="hashtags">
    <input type="text" name="search" class="form-control" style="max-width:300px"
           placeholder="#hashtag" value="#SpringSale">
    <button class="btn btn-primary">Track Hashtag</button>
  </form>
</div>

<canvas id="hashChart" height="100" class="mb-4"></canvas>

<table class="table table-striped">
  <thead class="table-dark">
    <tr><th>Hashtag</th><th>Posts</th><th>Engagement</th><th>Growth</th></tr>
  </thead>
  <tbody>
  <?php foreach ($hashtags as $h): ?>
  <tr>
    <td><strong><?php echo htmlspecialchars($h["tag"]); ?></strong></td>
    <td><?php echo number_format($h["posts"]); ?></td>
    <td><?php echo number_format($h["engagement"]); ?></td>
    <td>
      <span class="text-<?php echo strpos($h["growth"], '+') !== false ? 'success' : 'danger'; ?>">
        <?php echo htmlspecialchars($h["growth"]); ?>
      </span>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById("hashChart"), {
  type: "bar",
  data: {
    labels:   <?php echo json_encode(array_column($hashtags, "tag")); ?>,
    datasets: [
      { label: "Engagement", data: <?php echo json_encode(array_column($hashtags, "engagement")); ?>,
        backgroundColor: ["#0d6efd","#198754","#ffc107"] },
      { label: "Posts",      data: <?php echo json_encode(array_column($hashtags, "posts")); ?>,
        backgroundColor: ["#6ea8fe","#75b798","#ffda6a"], yAxisID: "y2" }
    ]
  },
  options: {
    scales: {
      y:  { beginAtZero: true, position: "left" },
      y2: { beginAtZero: true, position: "right", grid: { drawOnChartArea: false } }
    }
  }
});
</script>
<?php require "views/layouts/footer.php"; ?>