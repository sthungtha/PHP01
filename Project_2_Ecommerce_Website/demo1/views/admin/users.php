<?php require "views/layouts/header.php"; ?>
<h2>Manage Users</h2>

<?php if (isset($_SESSION["success"])): ?>
    <div class="alert alert-success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user["id"]; ?></td>
            <td><?php echo htmlspecialchars($user["username"]); ?></td>
            <td><?php echo htmlspecialchars($user["email"]); ?></td>
            <td>
                <span class="badge <?php echo $user["role"] === "admin" ? "bg-danger" : "bg-secondary"; ?>">
                    <?php echo ucfirst($user["role"]); ?>
                </span>
            </td>
            <td><?php echo date("M d, Y", strtotime($user["created_at"])); ?></td>
            <td>
                <?php if ($user["role"] !== "admin"): ?>
                <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteUser&id=<?php echo $user["id"]; ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this user permanently? This cannot be undone.');">
                    Delete User
                </a>
                <?php else: ?>
                <span class="text-muted">Admin cannot be deleted</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "views/layouts/footer.php"; ?>
