<?php require "views/layouts/header.php"; ?>
<h2>My Order History</h2>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">You have no orders yet.</div>
<?php else: ?>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?php echo $order["id"]; ?></td>
                <td><?php echo date("M d, Y H:i", strtotime($order["created_at"])); ?></td>
                <td>$<?php echo number_format($order["total"], 2); ?></td>
                <td>
                    <span class="badge bg-<?php echo $order["status"] === "pending" ? "warning" : "success"; ?>">
                        <?php echo ucfirst($order["status"]); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>
