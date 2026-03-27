<?php require "views/layouts/header.php"; ?>
<h2>Admin Dashboard</h2>
<div class="row g-3 mb-4">
  <div class="col-md-4"><div class="card text-center bg-primary text-white"><div class="card-body"><h5>Total Users</h5><h2><?php echo number_format($totalUsers); ?></h2></div></div></div>
  <div class="col-md-4"><div class="card text-center bg-success text-white"><div class="card-body"><h5>Scheduled Posts</h5><h2><?php echo number_format($totalPosts); ?></h2></div></div></div>
  <div class="col-md-4"><div class="card text-center bg-info text-white"><div class="card-body"><h5>Connected Platforms</h5><h2><?php echo $totalPlatforms; ?></h2></div></div></div>
</div>
<h5>Recent Registrations</h5>
<table class="table table-striped"><thead class="table-dark"><tr><th>Username</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody>
<?php foreach ($recentUsers as $u): ?>
<tr><td><?php echo htmlspecialchars($u["username"]); ?></td><td><?php echo htmlspecialchars($u["email"]); ?></td>
<td><?php echo ucfirst($u["role"]); ?></td><td><?php echo date("M d, Y", strtotime($u["created_at"])); ?></td></tr>
<?php endforeach; ?></tbody></table>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=users" class="btn btn-primary">Manage Users</a>
<?php require "views/layouts/footer.php"; ?>
