<?php require "views/layouts/header.php"; ?>
<div class="text-center py-5">
    <h1 class="text-success">✓ Order Placed Successfully!</h1>
    <p class="lead">Thank you for your purchase.</p>
    <p>Order Number: <strong>#<?php echo $orderId ?? "N/A"; ?></strong></p>
    
    <!-- Real PDF Download -->
    <a href="<?php echo BASE_URL; ?>invoice.php?order_id=<?php echo $orderId ?? "N/A"; ?>" 
       class="btn btn-outline-primary btn-lg mb-3" target="_blank">
        📄 Download Invoice (PDF)
    </a>
    
    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" class="btn btn-primary btn-lg">Continue Shopping</a>
</div>
<?php require "views/layouts/footer.php"; ?>
