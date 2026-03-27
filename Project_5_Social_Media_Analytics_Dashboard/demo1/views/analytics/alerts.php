<?php require "views/layouts/header.php"; ?>
<h2>Alerts & Notifications</h2>

<?php foreach ($alerts as $alert): ?>
<div class="alert alert-<?php echo $alert["type"]; ?>">
    <?php echo $alert["message"]; ?>
</div>
<?php endforeach; ?>

<?php require "views/layouts/footer.php"; ?>
