<?php require "views/layouts/header.php"; ?>
<h2>Categories</h2>
<ul class="list-group"><?php foreach ($categories as $cat): ?><li class="list-group-item"><a href="<?php echo BASE_URL; ?>index.php?controller=post&action=index&category=<?php echo $cat["id"]; ?>"><?php echo $cat["name"]; ?></a></li><?php endforeach; ?></ul>
<?php require "views/layouts/footer.php"; ?>
