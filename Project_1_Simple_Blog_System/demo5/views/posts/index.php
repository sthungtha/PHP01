<?php require "views/layouts/header.php"; ?>
<h1 class="mb-4">Recent Posts</h1>
<form method="get" class="mb-4">
    <input type="hidden" name="controller" value="post">
    <input type="hidden" name="action" value="index">
    <div class="input-group"><input type="text" name="search" class="form-control" placeholder="Search title or content..." value="<?php echo htmlspecialchars($search ?? ""); ?>">
    <button class="btn btn-primary" type="submit">Search</button></div>
</form>
<div class="mb-3"><?php foreach ($categories as $cat): ?><a href="<?php echo BASE_URL; ?>index.php?controller=post&action=index&category=<?php echo $cat["id"]; ?>" class="btn btn-outline-secondary me-1"><?php echo $cat["name"]; ?></a><?php endforeach; ?></div>
<div class="row">
    <?php foreach ($posts as $post): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <?php if ($post["featured_image"]): ?><img src="<?php echo BASE_URL; ?>public/<?php echo $post["featured_image"]; ?>" class="card-img-top" style="height:200px;object-fit:cover;"><?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($post["title"]); ?></h5>
                <p class="card-text"><?php echo getSearchHighlight(substr(strip_tags($post["content"]),0,120), $search ?? ""); ?>...</p>
                <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=show&id=<?php echo $post["id"]; ?>" class="btn btn-primary">Read More</a>
                <small class="text-muted d-block">By <?php echo $post["username"]; ?></small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<!-- Pagination (full implementation possible with $totalPosts) -->
<nav><ul class="pagination justify-content-center"><?php for($i=1; $i<=ceil($totalPosts/6); $i++): ?><li class="page-item"><a class="page-link" href="<?php echo BASE_URL; ?>index.php?controller=post&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php endfor; ?></ul></nav>
<?php require "views/layouts/footer.php"; ?>
