<?php require "views/layouts/header.php"; ?>
<h2>Reports &amp; Analytics</h2>

<div class="alert alert-info">
  Click any Download button to generate and save a real file.
  Weekly and monthly auto-email delivery is available in the production version.
</div>

<div class="row g-4">
<?php foreach ($reports as $report): ?>
  <?php
    $color = match($report["type"]) {
        "PDF"  => "danger",
        "CSV"  => "success",
        "XLSX" => "primary",
        default => "secondary",
    };
  ?>
  <div class="col-md-4">
    <div class="card h-100 shadow-sm">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title"><?php echo htmlspecialchars($report["title"]); ?></h5>
        <p class="text-muted mb-1">Period: <?php echo htmlspecialchars($report["date"]); ?></p>
        <span class="badge bg-<?php echo $color; ?> mb-3 align-self-start"><?php echo $report["type"]; ?></span>
        <a href="<?php echo BASE_URL; ?>index.php?controller=reports&action=download&file=<?php echo urlencode($report['file']); ?>"
           class="btn btn-<?php echo $color; ?> mt-auto w-100">
          Download <?php echo $report["type"]; ?>
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require "views/layouts/footer.php"; ?>