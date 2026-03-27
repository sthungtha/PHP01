<?php require "views/layouts/header.php"; ?>
<h2>User Profile</h2>
<?php if (isset($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <div class="mb-3"><label>Username</label><input type="text" name="username" value="<?php echo htmlspecialchars($user["username"]); ?>" class="form-control"></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
<?php require "views/layouts/footer.php"; ?>
