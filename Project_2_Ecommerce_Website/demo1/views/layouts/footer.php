    </div>

    <!-- Result Popup Messages -->
    <?php if (isset($_SESSION["success"])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index:9999; min-width:300px;">
        <?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION["error"])): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index:9999; min-width:300px;">
        <?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">&copy; 2026 My Shop Demo1</div>
    </footer>
</body>
</html>
