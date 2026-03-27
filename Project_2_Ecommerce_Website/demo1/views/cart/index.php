<?php require "views/layouts/header.php"; ?>
<h2>Your Shopping Cart</h2>

<?php if (empty($cartItems)): ?>
    <div class="alert alert-info">Your cart is empty. 
        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index">Browse Products</a>
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item["name"]); ?></td>
                <td>$<?php echo number_format($item["price"], 2); ?></td>
                <td><?php echo $item["quantity"]; ?></td>
                <td>$<?php echo number_format($item["subtotal"], 2); ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=cart&action=remove&id=<?php echo $item["id"]; ?>" 
                       class="btn btn-sm btn-danger">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end mt-4">
        <h4>Total: $<?php echo number_format($total, 2); ?></h4>
        
        <!-- WORKING Proceed to Checkout Button -->
        <a href="<?php echo BASE_URL; ?>index.php?controller=checkout&action=index" 
           class="btn btn-success btn-lg px-5">
            Proceed to Checkout →
        </a>
    </div>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>
