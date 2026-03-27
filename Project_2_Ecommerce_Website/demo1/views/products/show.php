<?php require "views/layouts/header.php"; ?>
<div class="row">
    <div class="col-md-6">
        <?php if (!empty($product['image'])): ?>
            <img src="<?php echo BASE_URL; ?>public/uploads/products/<?php echo $product['image']; ?>" 
                 class="img-fluid rounded" alt="">
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <h3 class="text-success">$<?php echo number_format($product['price'], 2); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($product['description'] ?? '')); ?></p>
        
        <!-- Add to Cart -->
        <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=cart&action=add" class="d-inline">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn btn-success btn-lg">Add to Cart</button>
        </form>

        <!-- Add to Wishlist -->
        <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=wishlist&action=add" class="d-inline ms-2">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn btn-outline-secondary btn-lg">♡ Add to Wishlist</button>
        </form>
    </div>
</div>

<!-- Customer Reviews -->
<h4 class="mt-5">Customer Reviews</h4>
<?php 
$reviewModel = new Review();
$reviews = $reviewModel->getReviewsByProduct($product['id']);
?>
<?php if (empty($reviews)): ?>
    <p class="text-muted">No reviews yet.</p>
<?php else: ?>
    <?php foreach ($reviews as $review): ?>
    <div class="border p-3 mb-3 rounded">
        <strong><?php echo htmlspecialchars($review['username']); ?></strong> 
        <span class="text-warning">★<?php echo $review['rating']; ?>/5</span>
        <p><?php echo htmlspecialchars($review['comment']); ?></p>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Review Form -->
<?php if (isLoggedIn()): ?>
<h5 class="mt-4">Write a Review</h5>
<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=review&action=add">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <div class="mb-3">
        <select name="rating" class="form-select" required>
            <option value="">Select rating</option>
            <option value="5">5 ★ Excellent</option>
            <option value="4">4 ★ Good</option>
            <option value="3">3 ★ Average</option>
            <option value="2">2 ★ Fair</option>
            <option value="1">1 ★ Poor</option>
        </select>
    </div>
    <div class="mb-3">
        <textarea name="comment" class="form-control" rows="4" placeholder="Write your review..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Review</button>
</form>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>
