<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h4>Social Media Analytics</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="admin@analytics.com" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=register">Create New Account</a>
                </div>

                <div class="text-center mt-3 small">
                    Demo Accounts:<br>
                    <strong>admin@analytics.com</strong> / password<br>
                    <strong>analyst@analytics.com</strong> / password
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>
