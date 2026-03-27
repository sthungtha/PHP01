<?php require "views/layouts/header.php"; ?>
<h2>Admin Dashboard</h2>

<div class="row text-center mb-5">
    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h3>Total Products</h3>
                <h2 class="text-primary"><?php echo $totalProducts ?? 0; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h3>Total Orders</h3>
                <h2 class="text-success"><?php echo $totalOrders ?? 0; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=manageProducts" 
           class="btn btn-primary btn-lg w-100 py-3">Manage Products</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=manageOrders" 
           class="btn btn-success btn-lg w-100 py-3">Manage Orders</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=manageUsers" 
           class="btn btn-info btn-lg w-100 py-3">Manage Users</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=reports" 
           class="btn btn-warning btn-lg w-100 py-3">Sales Reports</a>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
