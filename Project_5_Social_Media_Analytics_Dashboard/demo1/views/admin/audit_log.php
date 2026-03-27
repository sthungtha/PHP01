<?php require "views/layouts/header.php"; ?>
<h2>Audit Log</h2>
<p class="text-muted">Last 100 security events.</p>
<table class="table table-sm table-striped">
  <thead class="table-dark">
    <tr><th>Time</th><th>User</th><th>Action</th><th>Detail</th><th>IP</th></tr>
  </thead>
  <tbody>
  <?php foreach ($logs as $log): ?>
  <tr>
    <td><?php echo date("M d H:i:s", strtotime($log["created_at"])); ?></td>
    <td><?php echo htmlspecialchars($log["username"] ?? "system"); ?></td>
    <td><?php echo htmlspecialchars($log["action"]); ?></td>
    <td><?php echo htmlspecialchars($log["detail"]); ?></td>
    <td><?php echo htmlspecialchars($log["ip"]); ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=users" class="btn btn-secondary">Back to Users</a>
<?php require "views/layouts/footer.php"; ?>