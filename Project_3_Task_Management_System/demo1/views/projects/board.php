<?php require "views/layouts/header.php"; ?>
<h2>Project Board: <?php echo htmlspecialchars($project["name"]); ?></h2>

<!-- New Task Button -->
<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=createTaskForm&id=<?php echo $project["id"]; ?>" 
       class="btn btn-success btn-lg">
        <strong>+ New Task</strong>
    </a>
</div>

<div class="row">
    <?php foreach (["todo", "inprogress", "done"] as $status): ?>
    <div class="col-md-4">
        <h5 class="text-center"><?= ucfirst(str_replace("inprogress", "In Progress", $status)) ?></h5>
        <div class="list-group" id="column-<?= $status ?>" style="min-height: 500px; border: 2px dashed #ccc; border-radius: 8px; padding: 15px;">
            <?php foreach ($tasks as $t): if ($t["status"] === $status): ?>
            <div class="list-group-item mb-2 shadow-sm" draggable="true" data-task-id="<?= $t["id"] ?>" data-status="<?= $t["status"] ?>">
                <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=taskDetail&id=<?= $t["id"] ?>" class="text-decoration-none">
                    <?= htmlspecialchars($t["title"]) ?>
                </a>
                <?php if ($t["priority"] === "high"): ?><span class="badge bg-danger">High</span><?php endif; ?>
                <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=deleteTask&id=<?= $t["id"] ?>" 
                   onclick="return confirm('Delete this task?')" class="btn btn-sm btn-danger float-end">🗑</a>
            </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.list-group').forEach(column => {
        new Sortable(column, {
            group: "tasks",
            animation: 150,
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.id.replace("column-", "");
                fetch("<?php echo BASE_URL; ?>index.php?controller=project&action=updateTaskStatus", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: `task_id=${taskId}&status=${newStatus}&csrf_token=<?php echo generateCSRFToken(); ?>`
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) console.log("Status updated");
                  });
            }
        });
    });
</script>

<a href="<?php echo BASE_URL; ?>index.php?controller=project&action=index" class="btn btn-secondary mt-4">← Back to Projects</a>
<?php require "views/layouts/footer.php"; ?>
