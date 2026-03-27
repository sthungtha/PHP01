<?php
$randomNum      = rand(1000, 9999);
$randomUsername = "demo_user_" . $randomNum;
$randomEmail    = $randomUsername . "@example.com";
?>
<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center mt-5">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-header text-center bg-primary text-white">
        <h4>Create New Account</h4>
      </div>
      <div class="card-body">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
          <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?php echo $randomUsername; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?php echo $randomEmail; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   placeholder="Enter a password (min 6 chars)" required>
            <small class="text-muted">Demo tip: use <strong>password123</strong></small>
          </div>

          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
          <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Already have an account? Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "views/layouts/footer.php"; ?>