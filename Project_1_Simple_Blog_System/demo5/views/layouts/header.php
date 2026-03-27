<?php require_once __DIR__ . "/../../config/config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog System - Demo5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: "#content",
            height: 400,
            plugins: "link image lists",
            toolbar: "undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image"
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>index.php?controller=post&action=index">Simple Blog</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=post&action=index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=category&action=index">Categories</a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <?php if (isLoggedIn()): ?>
                        
                        <!-- Create New Post Button -->
                        <li class="nav-item me-2">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=create" 
                               class="btn btn-success btn-sm">
                                <strong>+ Create New Post</strong>
                            </a>
                        </li>

                        <!-- My Posts Link -->
                        <li class="nav-item me-3">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=post&action=myPosts" 
                               class="nav-link text-light">
                                My Posts
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile">
                                Profile (<?php echo htmlspecialchars($_SESSION["username"]); ?>)
                            </a>
                        </li>

                        <?php if (isAdmin()): ?>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=admin&action=dashboard">
                                    Admin Dashboard
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout">Logout</a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">