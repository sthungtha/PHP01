<?php require "views/layouts/header.php"; ?>
<h2>Manage Products</h2>

<a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=createProduct" class="btn btn-success mb-3">+ Add New Product</a>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td>$<?php echo number_format($p['price'], 2); ?></td>
            <td><?php echo $p['stock']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=editProduct&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteProduct&id=<?php echo $p['id']; ?>" 
                   class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "views/layouts/footer.php"; ?>
