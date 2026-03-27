<?php require "views/layouts/header.php"; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>🔗 Shared File</h4>
                </div>
                <div class="card-body text-center">
                    <h3><?php echo htmlspecialchars($share["original_name"]); ?></h3>
                    <p class="text-muted">Shared by <?php echo htmlspecialchars($share["owner_name"]); ?></p>

                    <?php if (strpos($share["file_type"], "image") !== false): ?>
                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($share["file_path"]); ?>" 
                             class="img-fluid rounded mb-4 shadow" style="max-height: 420px;">
                    <?php endif; ?>

                    <a href="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($share["file_path"]); ?>" 
                       class="btn btn-success btn-lg px-5" target="_blank">
                        ⬇️ Download File
                    </a>
                </div>
                <div class="card-footer text-center small text-muted">
                    Link <?php echo $share["expires_at"] ? "expires ".date("M d, Y", strtotime($share["expires_at"])) : "never expires"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>
