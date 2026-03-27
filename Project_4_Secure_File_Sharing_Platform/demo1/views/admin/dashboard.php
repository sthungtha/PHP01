<?php require "views/layouts/header.php"; ?>
<h2>Admin Dashboard</h2>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h5>Total Users</h5>
                <h2><?php echo number_format($totalUsers); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h5>Total Files</h5>
                <h2><?php echo number_format($totalFiles); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h5>Total Storage</h5>
                <h2><?php echo number_format($totalStorage / (1024*1024), 1); ?> MB</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning text-dark">
            <div class="card-body">
                <h5>Active Shares</h5>
                <h2><?php echo number_format($totalShares); ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=users" class="btn btn-primary">Manage Users</a>
    <a href="<?php echo BASE_URL; ?>index.php?controller=file&action=index" class="btn btn-secondary">Back to My Files</a>
</div>

<h5>Recent Activity</h5>
<?php if (empty($activities)): ?>
    <div class="alert alert-info">No activity recorded yet.</div>
<?php else: ?>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr><th>User</th><th>Action</th><th>Time</th></tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $a): ?>
            <tr>
                <td><?php echo htmlspecialchars($a["username"] ?? 'System'); ?></td>
                <td><?php echo htmlspecialchars($a["action"]); ?></td>
                <td><?php echo date("M d, H:i", strtotime($a["created_at"])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>
