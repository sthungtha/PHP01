<?php require "views/layouts/header.php"; ?>
<h1 class="mb-4">Our Products</h1>

<form method="GET" class="mb-4">
    <input type="hidden" name="controller" value="product">
    <input type="hidden" name="action" value="index">
    <div class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($_GET['search'] ?? ""); ?>">
        </div>
        <div class="col-md-3">
            <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ""); ?>">
        </div>
        <div class="col-md-3">
            <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ""); ?>">
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="newest">Newest</option>
                <option value="price_low">Price Low to High</option>
                <option value="price_high">Price High to Low</option>
            </select>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" type="submit">Apply Filter</button>
        </div>
    </div>
</form>

<div class="row">
    <?php foreach ($products as $p): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <?php if ($p['image']): ?>
                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=show&id=<?php echo $p['id']; ?>">
                    <img src="<?php echo BASE_URL; ?>public/uploads/products/<?php echo $p['image']; ?>" 
                         class="card-img-top" style="height:200px; object-fit:cover;">
                </a>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=show&id=<?php echo $p['id']; ?>" 
                       class="text-decoration-none text-dark">
                        <?php echo htmlspecialchars($p['name']); ?>
                    </a>
                </h5>
                <p class="text-success fw-bold">$<?php echo number_format($p['price'], 2); ?></p>
                <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=cart&action=add">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                    <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require "views/layouts/footer.php"; ?>
