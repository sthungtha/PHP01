<?php require "views/layouts/header.php"; ?>
<h2>New Task for Project: <?php echo htmlspecialchars($project["name"]); ?></h2>

<form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=project&action=createTask" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="project_id" value="<?php echo $project["id"]; ?>">

    <div class="mb-3">
        <label><strong>Title</strong></label>
        <input type="text" name="title" class="form-control" value="Implement user authentication" required>
    </div>
    <div class="mb-3">
        <label><strong>Description</strong></label>
        <textarea name="description" class="form-control" rows="4">Create secure login and registration system with password hashing and CSRF protection. Include email verification simulation.</textarea>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label><strong>Status</strong></label>
            <select name="status" class="form-select">
                <option value="todo" selected>To Do</option>
                <option value="inprogress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        <div class="col-md-3">
            <label><strong>Priority</strong></label>
            <select name="priority" class="form-select">
                <option value="high">High</option>
                <option value="medium" selected>Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <div class="col-md-3">
            <label><strong>Due Date</strong></label>
            <input type="date" name="due_date" class="form-control" value="<?php echo date("Y-m-d", strtotime("+7 days")); ?>">
        </div>
        <div class="col-md-3">
            <label><strong>Assign to</strong></label>
            <select name="assigned_to" class="form-select">
                <option value="">Unassigned</option>
                <?php foreach ($users as $u): ?>
                <option value="<?php echo $u["id"]; ?>" <?php echo ($u["id"] == 2) ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($u["username"]); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="mb-4 mt-4 border border-primary p-4 bg-light rounded">
        <label class="fw-bold"><strong>📎 Attachment / Image (optional)</strong></label>
        <input type="file" name="attachment" class="form-control">
        <small class="text-muted">You can upload images or documents later in task detail.</small>
    </div>

    <button type="submit" class="btn btn-success btn-lg">Create Task</button>
    <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=board&id=<?php echo $project["id"]; ?>" class="btn btn-secondary">Cancel</a>
</form>

<?php require "views/layouts/footer.php"; ?>
