<?php require "views/layouts/header.php"; ?>
<h2>Reports & Analytics</h2>

<div class="row">
    <div class="col-md-6">
        <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=board&id=1" class="text-decoration-none">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h3>Overdue Tasks</h3>
                    <h2 class="text-danger"><?php echo $overdue ?? 0; ?></h2>
                    <p class="text-muted">Click to view tasks</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=board&id=1" class="text-decoration-none">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h3>Completed Tasks</h3>
                    <h2 class="text-success"><?php echo $completed ?? 0; ?></h2>
                    <p class="text-muted">Click to view tasks</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="mt-4">
    <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=calendar" class="btn btn-info">View Calendar</a>
    <a href="<?php echo BASE_URL; ?>index.php?controller=project&action=exportCSV" class="btn btn-success">Export All Tasks to CSV</a>
</div>

<?php require "views/layouts/footer.php"; ?>
