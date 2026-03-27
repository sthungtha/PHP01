<?php require "views/layouts/header.php"; ?>
<h2>My Files</h2>

<?php if (isset($_SESSION["success"])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?>
        <?php if (isset($_SESSION["share_link"])): ?>
            <br><strong>Your Share Link:</strong>
            <a href="<?php echo htmlspecialchars($_SESSION['share_link']); ?>" target="_blank" class="text-break">
                <?php echo htmlspecialchars($_SESSION["share_link"]); ?>
            </a>
            <?php unset($_SESSION["share_link"]); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION["error"])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION["error"]); unset($_SESSION["error"]); ?></div>
<?php endif; ?>

<div id="drop-zone" class="border border-primary border-2 rounded p-5 text-center mb-4 bg-light"
     style="border-style: dashed !important; min-height: 200px; cursor: pointer;">
    <h4>Drag &amp; Drop Files Here</h4>
    <p class="text-muted">or click to select</p>
</div>

<form id="upload-form" method="POST"
      action="<?php echo BASE_URL; ?>index.php?controller=file&action=upload"
      enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="file" name="file" id="file-input" style="display:none;">
</form>

<div class="row mt-4">
    <?php if (empty($files)): ?>
        <div class="col-12"><div class="alert alert-info">No files yet. Upload something!</div></div>
    <?php else: ?>
        <?php foreach ($files as $file): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-truncate"><?php echo htmlspecialchars($file["original_name"]); ?></h6>
                    <p class="small text-muted">
                        <?php echo number_format($file["file_size"] / 1024, 1); ?> KB &bull;
                        <?php echo date("M d, Y", strtotime($file["created_at"])); ?>
                    </p>
                </div>
                <div class="card-footer bg-white d-flex flex-wrap gap-2">
                    <!-- Download -->
                    <a href="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($file["file_path"]); ?>"
                       class="btn btn-sm btn-primary flex-fill" target="_blank">Download</a>

                    <!-- Share -->
                    <button onclick="shareFile(<?php echo (int)$file['id']; ?>)"
                            class="btn btn-sm btn-success flex-fill">Share</button>

                    <!-- Revoke share (only shown when a share exists) -->
                    <?php if (!empty($file["share_id"])): ?>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=file&action=revokeShare&id=<?php echo (int)$file['share_id']; ?>&csrf_token=<?php echo urlencode(generateCSRFToken()); ?>"
                           class="btn btn-sm btn-outline-warning flex-fill"
                           onclick="return confirm('Revoke the share link for this file?')">Revoke Share</a>
                    <?php endif; ?>

                    <!-- Delete -->
                    <a href="<?php echo BASE_URL; ?>index.php?controller=file&action=deleteFile&id=<?php echo (int)$file['id']; ?>&csrf_token=<?php echo urlencode(generateCSRFToken()); ?>"
                       class="btn btn-sm btn-danger flex-fill"
                       onclick="return confirm('Permanently delete this file?')">Delete</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>index.php?controller=file&action=share">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                <input type="hidden" name="file_id" id="modal_file_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Expires after</label>
                        <select name="expires_days" class="form-select">
                            <option value="7">7 days</option>
                            <option value="30">30 days</option>
                            <option value="0">Never</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (optional)</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Leave empty for public access">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Generate Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const dropZone   = document.getElementById("drop-zone");
    const fileInput  = document.getElementById("file-input");
    const uploadForm = document.getElementById("upload-form");

    dropZone.addEventListener("click", () => fileInput.click());
    fileInput.addEventListener("change", () => uploadForm.submit());

    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = "#e3f2fd";
    });
    dropZone.addEventListener("dragleave", () => {
        dropZone.style.backgroundColor = "";
    });
    dropZone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = "";
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            uploadForm.submit();
        }
    });

    function shareFile(fileId) {
        document.getElementById("modal_file_id").value = fileId;
        new bootstrap.Modal(document.getElementById("shareModal")).show();
    }
</script>

<?php require "views/layouts/footer.php"; ?>

