<?php require "views/layouts/header.php"; ?>
<h2>Task Calendar</h2>

<div class="alert alert-info">
    <strong>Upcoming Tasks:</strong> Showing tasks with due dates in the next 30 days.
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Date</th>
            <th>Task</th>
            <th>Project</th>
            <th>Assigned</th>
            <th>Priority</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $t): ?>
        <tr>
            <td><?php echo date("M d, Y", strtotime($t['due_date'])); ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=taskDetail&id=<?php echo $t['id']; ?>">
                    <?php echo htmlspecialchars($t['title']); ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($t['project_name'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($t['assigned_name'] ?? 'Unassigned'); ?></td>
            <td>
                <span class="badge <?php echo $t['priority']=='high' ? 'bg-danger' : ($t['priority']=='medium' ? 'bg-warning' : 'bg-secondary'); ?>">
                    <?php echo ucfirst($t['priority']); ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo BASE_URL; ?>index.php?controller=project&action=index" class="btn btn-secondary mt-4">Back to My Projects</a>

<?php require "views/layouts/footer.php"; ?>
