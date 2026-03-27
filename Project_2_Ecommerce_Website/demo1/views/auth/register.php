<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Register New Account</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php 
                // Generate same base for username and email
                $baseName = "testuser" . rand(100, 999);
                ?>

                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?php echo $baseName; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo $baseName; ?>@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="password" required>
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
