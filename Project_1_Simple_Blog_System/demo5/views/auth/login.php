<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4>Login to Simple Blog</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <!-- Example data already filled for testing -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               value="admin@example.com" 
                               placeholder="admin@example.com" 
                               required>
                        <small class="text-muted">Example: admin@example.com</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               value="password" 
                               placeholder="password" 
                               required>
                        <small class="text-muted">Example: password (for both admin and user1)</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=register">Register here</a></p>
                    <p><a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=forgotPassword">Forgot Password?</a></p>
                </div>

                <hr>
                <div class="alert alert-info">
                    <strong>Test Accounts (pre-filled above):</strong><br>
                    • <strong>Admin:</strong> admin@example.com / password<br>
                    • <strong>Regular User:</strong> user1@example.com / password
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>