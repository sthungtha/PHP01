<?php require "views/layouts/header.php"; ?>
<h2>My Profile</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>
<div class="card shadow mb-3">
  <div class="card-body">
    <h5>Account Information</h5>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user["username"] ?? ""); ?></p>
    <p><strong>Email:</strong>    <?php echo htmlspecialchars($user["email"]    ?? ""); ?></p>
    <p><strong>Role:</strong>     <?php echo ucfirst($user["role"] ?? "analyst"); ?></p>
    <p><strong>Joined:</strong>   <?php echo date("M d, Y", strtotime($user["created_at"] ?? "now")); ?></p>
  </div>
</div>
<a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=changePassword" class="btn btn-warning me-2">Change Password</a>
<a href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index" class="btn btn-secondary">Back to Dashboard</a>
<?php require "views/layouts/footer.php"; ?>