<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header text-center bg-success text-white">
                <h4>Create an Account</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                               placeholder="3-50 chars, letters/numbers/_" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="At least 6 characters" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Create Account</button>
                </form>

                <div class="text-center mt-3">
                    Already have an account?
                    <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>