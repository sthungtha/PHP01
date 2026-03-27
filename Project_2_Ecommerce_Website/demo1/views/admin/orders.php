<?php require "views/layouts/header.php"; ?>
<h2>Manage Orders</h2>

<?php if (isset($_SESSION["success"])): ?>
    <div class="alert alert-success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?php echo $order["id"]; ?></td>
            <td><?php echo htmlspecialchars($order["username"]); ?></td>
            <td>$<?php echo number_format($order["total"], 2); ?></td>
            <td>
                <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=admin&action=updateOrderStatus" class="d-inline">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order["id"]; ?>">
                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                        <option value="pending" <?php echo $order["status"] === "pending" ? "selected" : ""; ?>>Pending</option>
                        <option value="processing" <?php echo $order["status"] === "processing" ? "selected" : ""; ?>>Processing</option>
                        <option value="shipped" <?php echo $order["status"] === "shipped" ? "selected" : ""; ?>>Shipped</option>
                        <option value="delivered" <?php echo $order["status"] === "delivered" ? "selected" : ""; ?>>Delivered</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary ms-1">Update</button>
                </form>
            </td>
            <td><?php echo date("M d, Y", strtotime($order["created_at"])); ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteOrder&id=<?php echo $order["id"]; ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this order permanently?');">
                    Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "views/layouts/footer.php"; ?>
