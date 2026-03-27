<?php require "views/layouts/header.php"; ?>
<h2>Task: <?php echo htmlspecialchars($task['title']); ?></h2>

<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=project&action=updateTask" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label><strong>Title</strong></label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label><strong>Description</strong></label>
                <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($task['description'] ?? ''); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label><strong>Status</strong></label>
                    <select name="status" class="form-select">
                        <option value="todo" <?php echo $task['status']=='todo'?'selected':''; ?>>To Do</option>
                        <option value="inprogress" <?php echo $task['status']=='inprogress'?'selected':''; ?>>In Progress</option>
                        <option value="done" <?php echo $task['status']=='done'?'selected':''; ?>>Done</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label><strong>Priority</strong></label>
                    <select name="priority" class="form-select">
                        <option value="high" <?php echo $task['priority']=='high'?'selected':''; ?>>High</option>
                        <option value="medium" <?php echo $task['priority']=='medium'?'selected':''; ?>>Medium</option>
                        <option value="low" <?php echo $task['priority']=='low'?'selected':''; ?>>Low</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label><strong>Due Date</strong></label>
                    <input type="date" name="due_date" class="form-control" value="<?php echo $task['due_date'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label><strong>Assign to</strong></label>
                    <select name="assigned_to" class="form-select">
                        <option value="">Unassigned</option>
                        <?php foreach ($users as $u): ?>
                        <option value="<?php echo $u['id']; ?>" <?php echo ($task['assigned_to'] == $u['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($u['username']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- ATTACHMENT SECTION - VERY VISIBLE -->
            <div class="mb-4 mt-4 border border-primary p-4 bg-light rounded">
                <label class="fw-bold fs-5"><strong>📎 Attachment / Image</strong></label><br>
                <input type="file" name="attachment" class="form-control form-control-lg">

                <?php if (!empty($task['attachment'])): ?>
                    <div class="mt-3 alert alert-success">
                        <strong>✅ Uploaded File/Image:</strong><br>
                        <a href="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($task['attachment']); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                            📄 View / Download <?php echo htmlspecialchars($task['attachment']); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mt-2 text-muted small">No file yet. Upload one above and click Save Changes.</div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
        </div>
    </div>
</form>

<!-- Comments & Activity Log (unchanged) -->
<h5 class="mt-5">Comments</h5>
<?php 
$commentModel = new Comment();
$comments = $commentModel->getByTask($task['id']);
?>
<?php if (empty($comments)): ?>
    <p class="text-muted">No comments yet. Be the first!</p>
<?php else: ?>
    <?php foreach ($comments as $c): ?>
    <div class="border p-3 mb-3 rounded">
        <strong><?php echo htmlspecialchars($c['username']); ?></strong> 
        <small class="text-muted"><?php echo date("M d, H:i", strtotime($c['created_at'])); ?></small>
        <p><?php echo htmlspecialchars($c['comment']); ?></p>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=project&action=addComment">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
    <textarea name="comment" class="form-control" rows="3" placeholder="Add your comment..." required>This looks good. Please coordinate with marketing team before final approval.</textarea>
    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
</form>

<h5 class="mt-5">Activity Log</h5>
<?php 
$activityModel = new Activity();
$activities = $activityModel->getByTask($task['id']);
?>
<?php if (empty($activities)): ?>
    <p class="text-muted">No activity yet.</p>
<?php else: ?>
    <ul class="list-group">
        <?php foreach ($activities as $a): ?>
        <li class="list-group-item">
            <strong><?php echo htmlspecialchars($a['username']); ?></strong> 
            <?php echo htmlspecialchars($a['action']); ?> 
            <small class="text-muted">• <?php echo date("M d, H:i", strtotime($a['created_at'])); ?></small>
        </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="<?php echo BASE_URL; ?>index.php?controller=project&action=board&id=<?php echo $task['project_id']; ?>" class="btn btn-secondary mt-4">← Back to Board</a>

<?php require "views/layouts/footer.php"; ?>
