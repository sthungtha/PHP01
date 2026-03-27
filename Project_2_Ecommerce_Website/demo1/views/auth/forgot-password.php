<?php require "views/layouts/header.php"; ?>
<h2>Forgot Password</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <div class="mb-3">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" value="admin@shop.com" required>
    </div>
    <button type="submit" class="btn btn-primary">Send Reset Link</button>
</form>
<p class="text-muted mt-3">Demo: Reset link would be sent to your email.</p>
<?php require "views/layouts/footer.php"; ?>
