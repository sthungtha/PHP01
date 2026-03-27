<?php require "views/layouts/header.php"; ?>
<h2>Admin Dashboard</h2>
<div class="row text-center">
    <div class="col-md-4"><div class="card"><div class="card-body"><h3>Total Posts</h3><h2><?php echo $totalPosts; ?></h2></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h3>Total Comments</h3><h2><?php echo $totalComments; ?></h2></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h3>Total Users</h3><h2><?php echo $totalUsers; ?></h2></div></div></div>
</div>
<p class="mt-4"><a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=managePosts" class="btn btn-primary me-2">Manage Posts</a>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=manageUsers" class="btn btn-primary me-2">Manage Users</a>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=manageCategories" class="btn btn-primary me-2">Manage Categories</a>
<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=moderateComments" class="btn btn-primary">Moderate Comments</a></p>
<?php require "views/layouts/footer.php"; ?>
