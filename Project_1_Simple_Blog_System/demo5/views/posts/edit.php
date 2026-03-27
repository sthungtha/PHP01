<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Post</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" 
                      action="<?php echo BASE_URL; ?>index.php?controller=post&action=edit&id=<?php echo $post['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Post Title</label>
                        <input type="text" 
                               name="title" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content</label>
                        <textarea id="content" name="content" class="form-control">
<?php echo htmlspecialchars($post['content'] ?? ''); ?>
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Featured Image</label>
                        <?php if (!empty($post['featured_image'])): ?>
                            <div class="mb-2">
                                <img src="<?php echo BASE_URL; ?>public/<?php echo $post['featured_image']; ?>" 
                                     alt="Current image" style="max-height: 200px;" class="img-thumbnail">
                                <small class="d-block text-muted">Current image</small>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Categories</label>
                        <div class="row">
                            <?php 
                            $selectedCats = [];
                            // In real code you would load assigned categories, but for simplicity:
                            foreach ($categories as $cat): 
                            ?>
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="<?php echo $cat['id']; ?>" 
                                           class="form-check-input" 
                                           id="cat<?php echo $cat['id']; ?>"
                                           <?php // You can improve this later to check existing categories ?>>
                                    <label class="form-check-label" for="cat<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-warning btn-lg px-5">Update Post</button>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=delete&id=<?php echo $post['id']; ?>" 
                           class="btn btn-danger btn-lg px-5"
                           onclick="return confirm('Are you sure you want to delete this post permanently?');">
                            Delete Post
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>