<?php require "views/layouts/header.php"; ?>
<h2>Content Management</h2>
<?php if (isset($_SESSION["success"])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?></div>
<?php endif; ?>

<div class="row">
<div class="col-md-5">
  <div class="card mb-4">
    <div class="card-header bg-primary text-white"><h5 class="mb-0">Schedule / Draft a Post</h5></div>
    <div class="card-body">
      <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=content&action=schedule">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="mb-2">
          <label class="form-label">Platform</label>
          <select name="platform" class="form-select" required>
            <option value="">-- Select --</option>
            <?php foreach (["Facebook","Instagram","Twitter","LinkedIn","YouTube"] as $pl): ?>
              <option <?php echo $pl === "Instagram" ? "selected" : ""; ?>><?php echo $pl; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Content</label>
          <textarea name="content" class="form-control" rows="3" required>Exciting news! Our spring collection is live. Check it out now and use code SPRING20 for 20% off. #SpringSale #NewArrival</textarea>
        </div>

        <div class="mb-2">
          <label class="form-label">Schedule Date &amp; Time</label>
          <input type="datetime-local" name="scheduled_at" class="form-control"
                 value="<?php echo date('Y-m-d\TH:i', strtotime('+1 day')); ?>" required>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" name="status" value="scheduled" class="btn btn-primary flex-fill">Schedule</button>
          <button type="submit" name="status" value="draft"     class="btn btn-secondary flex-fill">Save Draft</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-md-7">
  <h5>Scheduled &amp; Drafts</h5>
  <?php if (empty($posts)): ?>
    <p class="text-muted">No scheduled posts yet.</p>
  <?php else: ?>
  <table class="table table-sm table-striped">
    <thead class="table-dark">
      <tr><th>Platform</th><th>Content</th><th>Date</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $sp): ?>
    <tr>
      <td><?php echo htmlspecialchars($sp["platform"]); ?></td>
      <td><?php echo htmlspecialchars(substr($sp["content"], 0, 40)); ?>...</td>
      <td><?php echo date("M d H:i", strtotime($sp["scheduled_at"])); ?></td>
      <td>
        <span class="badge bg-<?php echo $sp["status"] === "draft" ? "secondary" : "success"; ?>">
          <?php echo ucfirst($sp["status"]); ?>
        </span>
      </td>
      <td>
        <a href="<?php echo BASE_URL; ?>index.php?controller=content&action=deletePost&id=<?php echo $sp['id']; ?>"
           class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove?')">Remove</a>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>

  <h5 class="mt-4">Recent Live Posts</h5>
  <table class="table table-sm table-striped">
    <thead class="table-dark">
      <tr><th>Platform</th><th>Post</th><th>Date</th><th>Engagement</th></tr>
    </thead>
    <tbody>
    <?php foreach ($livePosts as $post): ?>
    <tr>
      <td><?php echo htmlspecialchars($post["platform"]); ?></td>
      <td><?php echo htmlspecialchars($post["text"]); ?></td>
      <td><?php echo $post["date"]; ?></td>
      <td><?php echo number_format($post["engagement"]); ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</div>

<a href="<?php echo BASE_URL; ?>index.php?controller=content&action=calendar" class="btn btn-info mt-2">Content Calendar</a>
<?php require "views/layouts/footer.php"; ?>