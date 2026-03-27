<?php 
require_once __DIR__ . "/../../includes/helpers.php";
require_once __DIR__ . "/../../config/config.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop - Demo1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>">My Shop</a>
            
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=product&action=index">Shop</a></li>
            </ul>

            <ul class="navbar-nav align-items-center">
                <!-- Cart always visible (for guests and logged-in users) -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=cart&action=index">
                        Cart (<?php echo count(getCart()); ?>)
                    </a>
                </li>

                <?php if (isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=order&action=index">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=wishlist&action=index">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile">Profile</a></li>
                    
                    <?php if (isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=admin&action=dashboard">Admin</a></li>
                    <?php endif; ?>
                    
                    <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
