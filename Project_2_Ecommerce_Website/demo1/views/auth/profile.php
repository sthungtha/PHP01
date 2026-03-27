<?php require "views/layouts/header.php"; ?>
<h2>My Profile</h2>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

            <!-- Account Information -->
            <h5>Account Information</h5>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
            </div>

            <!-- Shipping Address -->
            <h5 class="mt-4">Shipping Address</h5>
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="John Doe" required>
            </div>
            <div class="mb-3">
                <label>Street Address</label>
                <input type="text" name="address" class="form-control" value="123 Main Street" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="New York" required>
                </div>
                <div class="col-md-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="NY" required>
                </div>
                <div class="col-md-3">
                    <label>ZIP Code</label>
                    <input type="text" name="zip" class="form-control" value="10001" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
        </form>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
