<?php require "views/layouts/header.php"; ?>
<h2>Sentiment Analysis</h2>
<div class="row">
<?php foreach ($sentimentData as $platform => $data): ?>
<div class="col-md-4 mb-4"><div class="card"><div class="card-body text-center">
  <h5 class="text-capitalize"><?php echo htmlspecialchars($platform); ?></h5>
  <canvas id="chart_<?php echo $platform; ?>" height="160"></canvas>
  <div class="d-flex justify-content-around mt-2 small">
    <span class="text-success">[+] <?php echo $data["positive"]; ?>% Positive</span>
    <span class="text-danger">[-] <?php echo $data["negative"]; ?>% Negative</span>
    <span class="text-secondary">[~] <?php echo $data["neutral"]; ?>% Neutral</span>
  </div>
</div></div></div>
<?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
<?php foreach ($sentimentData as $platform => $data): ?>
new Chart(document.getElementById("chart_<?php echo $platform; ?>"), {
  type: "doughnut",
  data: {
    labels: ["Positive","Negative","Neutral"],
    datasets: [{
      data: [<?php echo $data["positive"]; ?>, <?php echo $data["negative"]; ?>, <?php echo $data["neutral"]; ?>],
      backgroundColor: ["#198754","#dc3545","#adb5bd"]
    }]
  },
  options: { plugins: { legend: { display: false } } }
});
<?php endforeach; ?>
</script>
<?php require "views/layouts/footer.php"; ?>