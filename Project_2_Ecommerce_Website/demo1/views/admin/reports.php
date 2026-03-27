<?php require "views/layouts/header.php"; ?>
<h2>Sales Reports</h2>

<h5>Top 5 Best Selling Products</h5>
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Units Sold</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($topProducts as $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo $p['total_sold']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "views/layouts/footer.php"; ?>
