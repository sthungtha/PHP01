<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnalyticsHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head><body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index">AnalyticsHub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=platform&action=connect">Connect</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=content&action=index">Content</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=content&action=calendar">Calendar</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=reports&action=index">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=analytics&action=sentiment">Sentiment</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=analytics&action=hashtags">Hashtags</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=alerts&action=index">Alerts</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=competitor&action=index">Competitors</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=api&action=index">API</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="<?php echo BASE_URL; ?>index.php?controller=admin&action=users">Users</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=profile">Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid px-4 mt-4">
