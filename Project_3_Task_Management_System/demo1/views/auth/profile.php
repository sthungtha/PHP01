<?php require "views/layouts/header.php"; ?>
<h2>My Profile</h2>
<div class="card">
    <div class="card-body">
        <h5>Account Information</h5>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($userData["username"] ?? ""); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($userData["email"] ?? ""); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($userData["role"] ?? ""); ?></p>
    </div>
</div>
<a href="<?php echo BASE_URL; ?>index.php?controller=project&action=index" class="btn btn-secondary mt-3">Back to Dashboard</a>
<?php require "views/layouts/footer.php"; ?>
