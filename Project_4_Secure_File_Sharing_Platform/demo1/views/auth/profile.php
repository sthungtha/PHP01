<?php require "views/layouts/header.php"; ?>
<h2>My Profile</h2>

<div class="card shadow">
    <div class="card-body">
        <h5>Account Information</h5>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user["username"] ?? ""); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"] ?? ""); ?></p>
        <p><strong>Role:</strong> <?php echo ucfirst($user["role"] ?? "regular"); ?></p>
        <p><strong>Storage Used:</strong> <?php echo number_format(($user["storage_used"] ?? 0) / (1024*1024), 1); ?> MB</p>

        <hr>

        <a href="<?php echo BASE_URL; ?>index.php?controller=file&action=index" class="btn btn-primary">
            Back to My Files
        </a>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
