<?php require "views/layouts/header.php"; ?>
<h2>My Wishlist</h2>

<?php if (empty($products)): ?>
    <div class="alert alert-info">Your wishlist is empty.</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($products as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($p['image']): ?>
                    <img src="<?php echo BASE_URL; ?>public/uploads/products/<?php echo $p['image']; ?>" 
                         class="card-img-top" style="height:200px; object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($p['name']); ?></h5>
                    <p class="text-success fw-bold">$<?php echo number_format($p['price'], 2); ?></p>
                    
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=show&id=<?php echo $p['id']; ?>" 
                       class="btn btn-primary btn-sm">View Details</a>
                    
                    <a href="<?php echo BASE_URL; ?>index.php?controller=wishlist&action=remove&id=<?php echo $p['id']; ?>" 
                       class="btn btn-danger btn-sm mt-2" 
                       onclick="return confirm('Remove from wishlist?');">
                        Remove
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>
