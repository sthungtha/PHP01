<?php require "views/layouts/header.php"; ?>
<h2>Manage Users</h2>

<?php if (isset($_SESSION["success"])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION["error"])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION["error"]); unset($_SESSION["error"]); ?></div>
<?php endif; ?>

<table class="table table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Storage Used</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u2): ?>
        <tr>
            <td><?php echo $u2["id"]; ?></td>
            <td><?php echo htmlspecialchars($u2["username"]); ?></td>
            <td><?php echo htmlspecialchars($u2["email"]); ?></td>
            <td>
                <?php if ($u2["role"] === "suspended"): ?>
                    <span class="badge bg-danger">Suspended</span>
                <?php elseif ($u2["role"] === "admin"): ?>
                    <span class="badge bg-warning text-dark">Admin</span>
                <?php elseif ($u2["role"] === "premium"): ?>
                    <span class="badge bg-success">Premium</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Regular</span>
                <?php endif; ?>
            </td>
            <td><?php echo number_format(($u2["storage_used"] ?? 0) / (1024 * 1024), 1); ?> MB</td>
            <td>
                <?php if ($u2["id"] == $_SESSION["user_id"]): ?>
                    <span class="text-muted fst-italic">Your account</span>
                <?php elseif ($u2["role"] === "admin"): ?>
                    <span class="text-muted fst-italic">Admin (protected)</span>
                <?php else: ?>
                    <?php
                        $csrfToken  = generateCSRFToken();
                        $baseAction = BASE_URL . "index.php?controller=admin&action=manageUser&csrf_token=" . urlencode($csrfToken) . "&id=" . $u2["id"] . "&user_action=";
                    ?>
                    <?php if ($u2["role"] !== "suspended"): ?>
                        <a href="<?php echo $baseAction; ?>suspend"
                           class="btn btn-sm btn-warning"
                           onclick="return confirm('Suspend this user?')">Suspend</a>
                    <?php else: ?>
                        <a href="<?php echo $baseAction; ?>unsuspend"
                           class="btn btn-sm btn-success"
                           onclick="return confirm('Reinstate this user?')">Unsuspend</a>
                    <?php endif; ?>
                    <a href="<?php echo $baseAction; ?>delete"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Permanently delete this user and all their files? This cannot be undone.')">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=dashboard" class="btn btn-secondary">Back to Dashboard</a>
<?php require "views/layouts/footer.php"; ?>