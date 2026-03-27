<?php require "views/layouts/header.php"; ?>
<h2>Create New Project</h2>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <div class="mb-3">
        <label>Project Name</label>
        <input type="text" name="name" class="form-control" value="Website Redesign" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">Complete overhaul of the company website with modern design and improved user experience.</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create Project</button>
</form>

<?php require "views/layouts/footer.php"; ?>
