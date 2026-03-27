<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center mt-4">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-header bg-warning text-dark"><h5 class="mb-0">Change Password</h5></div>
      <div class="card-body">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
          <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" minlength="6" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-warning w-100">Update Password</button>
        </form>
        <div class="mt-3 text-center">
          <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "views/layouts/footer.php"; ?>