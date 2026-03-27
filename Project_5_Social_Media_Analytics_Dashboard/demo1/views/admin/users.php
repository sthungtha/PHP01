<?php require "views/layouts/header.php"; ?>
<h2>Manage Users</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION["error"])): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION["error"]); unset($_SESSION["error"]); ?></div>
<?php endif; ?>

<div class="mb-3">
  <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=auditLog" class="btn btn-outline-secondary btn-sm">View Audit Log</a>
</div>

<table class="table table-striped">
  <thead class="table-dark">
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr>
  </thead>
  <tbody>
  <?php foreach ($users as $u): ?>
  <tr>
    <td><?php echo $u["id"]; ?></td>
    <td><?php echo htmlspecialchars($u["username"]); ?></td>
    <td><?php echo htmlspecialchars($u["email"]); ?></td>
    <td>
      <?php if ($u["role"] === "suspended"): ?><span class="badge bg-danger">Suspended</span>
      <?php elseif ($u["role"] === "admin"):    ?><span class="badge bg-dark">Admin</span>
      <?php elseif ($u["role"] === "manager"):  ?><span class="badge bg-primary">Manager</span>
      <?php else: ?><span class="badge bg-secondary">Analyst</span><?php endif; ?>
    </td>
    <td><?php echo date("M d, Y", strtotime($u["created_at"])); ?></td>
    <td class="d-flex gap-1 flex-wrap">
      <?php if ($u["id"] == $_SESSION["user_id"]): ?>
        <span class="text-muted">Self (protected)</span>
      <?php elseif ($u["role"] === "admin"): ?>
        <span class="text-muted">Admin (protected)</span>
      <?php elseif ($u["role"] === "suspended"): ?>
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=unsuspendUser&id=<?php echo $u['id']; ?>"
           class="btn btn-sm btn-success" onclick="return confirm('Unsuspend this user?')">Unsuspend</a>
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteUser&id=<?php echo $u['id']; ?>"
           class="btn btn-sm btn-danger" onclick="return confirm('Delete permanently?')">Delete</a>
      <?php else: ?>
        <?php if ($u["role"] === "analyst"): ?>
          <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=promoteUser&id=<?php echo $u['id']; ?>"
             class="btn btn-sm btn-info" onclick="return confirm('Promote to Manager?')">Promote</a>
        <?php endif; ?>
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=suspendUser&id=<?php echo $u['id']; ?>"
           class="btn btn-sm btn-warning" onclick="return confirm('Suspend this user?')">Suspend</a>
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteUser&id=<?php echo $u['id']; ?>"
           class="btn btn-sm btn-danger" onclick="return confirm('Delete permanently?')">Delete</a>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=dashboard" class="btn btn-secondary">Back to Dashboard</a>
<?php require "views/layouts/footer.php"; ?>