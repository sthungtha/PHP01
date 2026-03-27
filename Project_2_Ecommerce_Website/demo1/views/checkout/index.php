<?php require "views/layouts/header.php"; ?>
<h2>Checkout</h2>

<div class="row">
    <div class="col-md-8">
        <!-- Shipping Address -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Shipping Address</div>
            <div class="card-body">
                <p><strong>Full Name:</strong> John Doe</p>
                <p><strong>Street Address:</strong> 123 Main Street</p>
                <p><strong>City, State, ZIP:</strong> New York, NY 10001</p>
                <p><strong>Phone:</strong> (555) 123-4567</p>
                <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile" class="btn btn-sm btn-outline-secondary">Edit Address</a>
            </div>
        </div>

        <!-- Shipping Methods -->
        <div class="card mb-4">
            <div class="card-header">Shipping Method</div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="radio" name="shipping_method" value="standard" class="form-check-input" checked>
                    <label class="form-check-label">
                        <strong>Standard Shipping</strong> (3-5 business days) - $5.99
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input type="radio" name="shipping_method" value="express" class="form-check-input">
                    <label class="form-check-label">
                        <strong>Express Shipping</strong> (1-2 business days) - $12.99
                    </label>
                </div>
                <div class="form-check">
                    <input type="radio" name="shipping_method" value="pickup" class="form-check-input">
                    <label class="form-check-label">
                        <strong>Store Pickup</strong> - Free
                    </label>
                </div>
            </div>
        </div>

        <!-- Coupon -->
        <div class="card mb-4">
            <div class="card-header">Apply Coupon</div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <div class="input-group">
                        <input type="text" name="coupon_code" class="form-control" value="SAVE10" placeholder="Coupon code">
                        <button type="submit" class="btn btn-outline-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                <?php foreach ($cartItems as $item): ?>
                <div class="d-flex justify-content-between mb-1">
                    <span><?php echo htmlspecialchars($item["name"]); ?> × <?php echo $item["quantity"]; ?></span>
                    <span>$<?php echo number_format($item["subtotal"], 2); ?></span>
                </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span>$<?php echo number_format($finalTotal ?? $total, 2); ?></span>
                </div>
            </div>
            <div class="card-footer">
                <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=checkout&action=confirm">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        Complete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
