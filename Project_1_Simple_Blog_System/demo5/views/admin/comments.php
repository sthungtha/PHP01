<?php 
$pageTitle = "Moderate Comments";
require "views/layouts/header.php"; 
?>
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">📋 Moderate Comments</h2>

        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Quick Test Button -->
        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=createTestComment" 
               class="btn btn-outline-primary">
                ➕ Add Test Pending Comment (for testing)
            </a>
        </div>

        <!-- Pending Comments -->
        <h5>Pending Comments (Need Approval)</h5>
        <?php if (empty($pendingComments)): ?>
            <div class="alert alert-success">
                <strong>Great!</strong> No pending comments right now. All comments are already moderated.
            </div>
        <?php else: ?>
            <div class="table-responsive mb-5">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Post</th>
                            <th>User</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingComments as $comment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($comment['post_title']); ?></td>
                            <td><?php echo htmlspecialchars($comment['username']); ?></td>
                            <td><?php echo htmlspecialchars($comment['content']); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($comment['created_at'])); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form method="POST" class="d-inline ms-1">
                                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- All Recent Comments -->
        <h5 class="mt-5">📜 All Recent Comments</h5>
        <?php
        global $pdo;
        $allComments = $pdo->query("SELECT c.*, p.title as post_title, u.username, c.status 
                                    FROM comments c 
                                    JOIN posts p ON c.post_id = p.id 
                                    JOIN users u ON c.user_id = u.id 
                                    ORDER BY c.created_at DESC LIMIT 20")->fetchAll();
        ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Post</th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allComments as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['post_title']); ?></td>
                        <td><?php echo htmlspecialchars($c['username']); ?></td>
                        <td><?php echo htmlspecialchars($c['content']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $c['status'] === 'approved' ? 'success' : ($c['status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                                <?php echo ucfirst($c['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($c['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "views/layouts/footer.php"; ?>