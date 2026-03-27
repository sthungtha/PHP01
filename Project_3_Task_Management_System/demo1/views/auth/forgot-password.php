<?php require "views/layouts/header.php"; ?>
<h2>Forgot Password</h2>

<div class="card">
    <div class="card-body">
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="test@task.com" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
