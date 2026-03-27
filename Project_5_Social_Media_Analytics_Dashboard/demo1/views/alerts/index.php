<?php require "views/layouts/header.php"; ?>
<h2>Alerts &amp; Notifications</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<h5>System Alerts</h5>
<?php foreach ($alerts as $alert): ?>
<div class="alert alert-<?php echo htmlspecialchars($alert["type"]); ?> d-flex justify-content-between align-items-center">
  <span><?php echo htmlspecialchars($alert["message"]); ?></span>
  <small class="text-muted">Just now</small>
</div>
<?php endforeach; ?>

<hr class="my-4">
<div class="row">
  <div class="col-md-5">
    <h5>Add Custom Alert Threshold</h5>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=alerts&action=saveThreshold">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="mb-2">
          <label class="form-label">Metric</label>
          <select name="metric" class="form-select">
            <option value="engagement" selected>Engagement Rate</option>
            <option value="followers">Followers</option>
            <option value="reach">Reach</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Platform</label>
          <select name="platform" class="form-select">
            <option value="instagram" selected>instagram</option>
            <option value="facebook">facebook</option>
            <option value="twitter">twitter</option>
            <option value="linkedin">linkedin</option>
            <option value="youtube">youtube</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Threshold Value</label>
          <input type="number" name="threshold_value" step="0.1" class="form-control"
                 value="5.0" placeholder="e.g. 5.0" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Alert When Value Is</label>
          <select name="direction" class="form-select">
            <option value="below" selected>Below threshold</option>
            <option value="above">Above threshold</option>
          </select>
        </div>
        <button type="submit" class="btn btn-dark w-100">Save Alert</button>
      </form>
    </div></div>
  </div>

  <div class="col-md-7">
    <h5>Your Custom Thresholds</h5>
    <?php if (empty($thresholds)): ?>
      <p class="text-muted">No custom alerts set yet. Use the form to add one.</p>
    <?php else: ?>
    <table class="table table-striped table-sm">
      <thead class="table-dark">
        <tr><th>Platform</th><th>Metric</th><th>Threshold</th><th>Direction</th><th></th></tr>
      </thead>
      <tbody>
      <?php foreach ($thresholds as $t): ?>
      <tr>
        <td><?php echo ucfirst(htmlspecialchars($t["platform"])); ?></td>
        <td><?php echo htmlspecialchars($t["metric"]); ?></td>
        <td><?php echo $t["threshold_value"]; ?></td>
        <td><?php echo $t["direction"]; ?></td>
        <td>
          <a href="<?php echo BASE_URL; ?>index.php?controller=alerts&action=deleteThreshold&id=<?php echo $t['id']; ?>"
             class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this threshold?')">Remove</a>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

<p class="text-muted mt-4 small">Real-time alerts use polling in this demo. Production uses WebSockets.</p>
<?php require "views/layouts/footer.php"; ?>