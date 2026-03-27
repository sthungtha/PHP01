<?php require "views/layouts/header.php"; ?>
<h2>Edit Product</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" name="name" class="form-control" 
                       value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="4" required>
<?php echo htmlspecialchars($product['description'] ?? ''); ?>
                </textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" 
                           value="<?php echo $product['price'] ?? ''; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control" 
                           value="<?php echo $product['stock'] ?? ''; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-control">
                        <?php 
                        global $pdo;
                        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
                        foreach ($cats as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" 
                                <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label fw-bold">Current Image</label><br>
                <?php if ($product['image']): ?>
                    <img src="<?php echo BASE_URL; ?>public/uploads/products/<?php echo $product['image']; ?>" 
                         style="max-height:150px;" class="img-thumbnail"><br>
                <?php endif; ?>
                <label class="form-label mt-2">New Image (optional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning btn-lg px-5">Update Product</button>
            <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=deleteProduct&id=<?php echo $product['id']; ?>" 
               class="btn btn-danger btn-lg px-5"
               onclick="return confirm('Delete this product permanently?');">Delete Product</a>
        </form>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
