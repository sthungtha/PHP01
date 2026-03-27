<?php require "views/layouts/header.php"; ?>
<h2>My Posts</h2>

<?php if (empty($posts)): ?>
    <div class="alert alert-info">You haven't created any posts yet.</div>
    <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=create" class="btn btn-success">Create Your First Post</a>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=show&id=<?php echo $post['id']; ?>">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=edit&id=<?php echo $post['id']; ?>" 
                           class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=delete&id=<?php echo $post['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require "views/layouts/footer.php"; ?>