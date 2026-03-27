<?php require "views/layouts/header.php"; ?>
<h2>My Projects</h2>

<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=create" class="btn btn-primary">+ New Project</a>
</div>

<table class="table table-hover">
    <thead class="table-dark"><tr><th>Name</th><th>Description</th><th>Created By</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($projects as $p): ?>
        <tr>
            <td><a href="<?php echo BASE_URL; ?>index.php?controller=project&action=board&id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a></td>
            <td><?= htmlspecialchars($p['description'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['created_by_name'] ?? 'Unknown') ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=deleteProject&id=<?= $p['id'] ?>" 
                   onclick="return confirm('Delete this project and ALL tasks?')" class="btn btn-sm btn-danger">🗑 Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require "views/layouts/footer.php"; ?>
