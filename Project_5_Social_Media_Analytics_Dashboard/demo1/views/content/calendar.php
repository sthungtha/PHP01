<?php require "views/layouts/header.php"; ?>
<h2>Content Calendar</h2>
<?php if (empty($calPosts)): ?>
  <div class="alert alert-info">No scheduled posts yet. <a href="<?php echo BASE_URL; ?>index.php?controller=content&action=index">Schedule one now</a>.</div>
<?php else: ?>
<table class="table table-bordered"><thead><tr><th>Date</th><th>Platform</th><th>Content</th><th>Status</th></tr></thead><tbody>
<?php foreach ($calPosts as $cp): ?><tr>
  <td><?php echo date("M d, Y H:i", strtotime($cp["scheduled_at"])); ?></td>
  <td><?php echo htmlspecialchars($cp["platform"]); ?></td>
  <td><?php echo htmlspecialchars($cp["content"]); ?></td>
  <td><span class="badge bg-<?php echo $cp["status"]==="draft"?"secondary":"success"; ?>"><?php echo ucfirst($cp["status"]); ?></span></td>
</tr><?php endforeach; ?></tbody></table>
<?php endif; ?>
<a href="<?php echo BASE_URL; ?>index.php?controller=content&action=index" class="btn btn-secondary">Back to Content</a>
<?php require "views/layouts/footer.php"; ?>
