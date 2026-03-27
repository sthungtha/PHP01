<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4>Create New Account</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=auth&action=register">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <!-- Example data pre-filled for testing -->
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" 
                               name="username" 
                               class="form-control" 
                               value="testuser" 
                               placeholder="testuser" 
                               required>
                        <small class="text-muted">Example: testuser</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               value="testuser@example.com" 
                               placeholder="testuser@example.com" 
                               required>
                        <small class="text-muted">Example: testuser@example.com</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               value="password" 
                               placeholder="password" 
                               required>
                        <small class="text-muted">Example: password (minimum 6 characters recommended)</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Register Account</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login here</a></p>
                </div>

                <hr>
                <div class="alert alert-info">
                    <strong>Pre-filled Test Data:</strong><br>
                    Username: testuser<br>
                    Email: testuser@example.com<br>
                    Password: password
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>