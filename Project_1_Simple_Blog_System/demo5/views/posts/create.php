<?php require "views/layouts/header.php"; ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Create New Post</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>index.php?controller=post&action=create">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <!-- Example data pre-filled -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Post Title</label>
                        <input type="text" 
                               name="title" 
                               class="form-control" 
                               value="My First Awesome Blog Post" 
                               placeholder="Enter post title" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content</label>
                        <textarea id="content" name="content" class="form-control">
&lt;h3&gt;Welcome to my blog!&lt;/h3&gt;
&lt;p&gt;This is a demo post created with the rich text editor (TinyMCE). You can format text, add lists, links, and even images.&lt;/p&gt;
&lt;p&gt;Feel free to edit this content as you like.&lt;/p&gt;
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Featured Image</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended size: 800x500 px (JPG, PNG, GIF)</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Categories (Select multiple)</label>
                        <div class="row">
                            <?php foreach ($categories as $cat): ?>
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="<?php echo $cat['id']; ?>" 
                                           class="form-check-input" 
                                           id="cat<?php echo $cat['id']; ?>">
                                    <label class="form-check-label" for="cat<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">Publish Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>