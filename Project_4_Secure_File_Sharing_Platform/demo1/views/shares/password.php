<?php require "views/layouts/header.php"; ?>
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h4>Password Protected Link</h4>
            <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
            <form method="POST">
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                <button type="submit" class="btn btn-primary mt-3 w-100">Unlock</button>
            </form>
        </div>
    </div>
</div>
<?php require "views/layouts/footer.php"; ?>
