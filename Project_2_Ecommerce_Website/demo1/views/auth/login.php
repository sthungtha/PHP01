<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4>Login to My Shop</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="admin@shop.com" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=forgotPassword">Forgot Password?</a>
                </div>

                <div class="alert alert-info mt-4">
                    <strong>Test Accounts:</strong><br>
                    Admin: admin@shop.com / password<br>
                    Customer: customer@shop.com / password
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>
