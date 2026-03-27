<?php require "views/layouts/header.php"; ?>
<h1><?php echo htmlspecialchars($post["title"]); ?></h1>
<?php if ($post["featured_image"]): ?><img src="<?php echo BASE_URL; ?>public/<?php echo $post["featured_image"]; ?>" class="img-fluid mb-4" alt=""><?php endif; ?>
<div><?php echo $post["content"]; ?></div>
<p class="text-muted">By <?php echo $post["username"]; ?> â€¢ <?php echo $post["created_at"]; ?></p>
<h3>Comments</h3>
<?php foreach ($comments as $comment): ?>
<div class="border p-3 mb-2"><strong><?php echo $comment["username"]; ?>:</strong> <?php echo htmlspecialchars($comment["content"]); ?></div>
<?php endforeach; ?>
<?php if (isLoggedIn()): ?>
<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=comment&action=create">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
    <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..." required></textarea>
    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
    <small class="text-muted d-block mt-1">Your comment will be reviewed if you're not admin.</small>
</form>
<?php endif; ?><?php require "views/layouts/footer.php"; ?>
