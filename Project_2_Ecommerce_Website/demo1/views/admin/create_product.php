<?php require "views/layouts/header.php"; ?>
<h2>Add New Product</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

            <!-- Rich pre-filled example data -->
            <div class="mb-3">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" name="name" class="form-control" 
                       value="Portable Bluetooth Speaker" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="5" required>
Powerful portable Bluetooth speaker with 360° sound, 15-hour battery life, IPX7 waterproof rating, and built-in microphone for calls. Perfect for beach, camping, and parties.
                </textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" 
                           value="59.99" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control" 
                           value="85" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-control">
                        <?php 
                        global $pdo;
                        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
                        foreach ($cats as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label fw-bold">Product Image</label>
                <input type="file" name="image" class="form-control">
                <small class="text-muted">Optional - JPG or PNG recommended</small>
            </div>

            <button type="submit" class="btn btn-success btn-lg px-5">Create Product</button>
        </form>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>
