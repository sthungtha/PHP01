<?php require "views/layouts/header.php"; ?>
<h2>Competitor Analysis</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<div class="row">
<div class="col-md-4">
  <div class="card mb-4">
    <div class="card-header bg-dark text-white"><h6 class="mb-0">Track a Competitor</h6></div>
    <div class="card-body">
      <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=competitor&action=add">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="mb-2">
          <label class="form-label">Brand Name</label>
          <input name="name" class="form-control" placeholder="Brand name"
                 value="BrandRival" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Handle</label>
          <input name="handle" class="form-control" placeholder="@handle"
                 value="@brandrival">
        </div>
        <div class="mb-2">
          <label class="form-label">Platform</label>
          <select name="platform" class="form-select">
            <option>Instagram</option><option>Twitter</option>
            <option>Facebook</option><option>LinkedIn</option><option>YouTube</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Followers</label>
          <input name="followers" type="number" class="form-control"
                 placeholder="Followers" value="52000" min="0" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Engagement %</label>
          <input name="engagement" type="number" step="0.1" class="form-control"
                 placeholder="Engagement %" value="7.4" min="0" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Growth</label>
          <input name="growth" class="form-control"
                 placeholder="e.g. +12%" value="+8%">
        </div>
        <button class="btn btn-dark w-100">Add Competitor</button>
      </form>
    </div>
  </div>
</div>

<div class="col-md-8">
  <table class="table table-striped">
    <thead class="table-dark">
      <tr><th>Competitor</th><th>Followers</th><th>Engagement</th><th>Growth</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($competitors as $i => $c): ?>
    <tr>
      <td><strong><?php echo htmlspecialchars($c["name"]); ?></strong></td>
      <td><?php echo number_format($c["followers"]); ?></td>
      <td><?php echo $c["engagement"]; ?>%</td>
      <td>
        <span class="text-<?php echo (strpos($c["growth"], '+') !== false) ? 'success' : 'danger'; ?>">
          <?php echo htmlspecialchars($c["growth"]); ?>
        </span>
      </td>
      <td>
        <?php if ($i >= 3): ?>
          <a href="<?php echo BASE_URL; ?>index.php?controller=competitor&action=remove&id=<?php echo $savedCompetitors[$i-3]['id']; ?>"
             class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove?')">Remove</a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <canvas id="compChart" height="120" class="mt-3"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>
  new Chart(document.getElementById("compChart"), {
    type: "bar",
    data: {
      labels:   <?php echo json_encode(array_column($competitors, "name")); ?>,
      datasets: [{ label: "Engagement %",
                   data: <?php echo json_encode(array_column($competitors, "engagement")); ?>,
                   backgroundColor: "rgba(13,110,253,0.7)" }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
  </script>
</div>
</div>
<?php require "views/layouts/footer.php"; ?>