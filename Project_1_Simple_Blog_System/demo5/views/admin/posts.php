<?php require "views/layouts/header.php"; ?>
<h2>Manage All Posts</h2>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars($post['username']); ?></td>
                <td>
                    <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                        <?php echo ucfirst($post['status']); ?>
                    </span>
                </td>
                <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=edit&id=<?php echo $post['id']; ?>" 
                       class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=delete&id=<?php echo $post['id']; ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this post?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (empty($posts)): ?>
    <div class="alert alert-info">No posts found.</div>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>