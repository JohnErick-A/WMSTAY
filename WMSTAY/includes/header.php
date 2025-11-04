<?php if (!isset($title)) $title = "WMSTAY"; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= htmlspecialchars($title) ?> - WMSTAY</title>
  <link href="/WMSTAY/assets/css/style.css" rel="stylesheet">
  <script src="/WMSTAY/assets/js/script.js" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="app">
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <div class="logo"></div>
      <div class="brand-text">WMSTAY</div>
    </div>
    <nav class="menu">
      <?php if(isset($_SESSION['user'])): ?>
        <?php if($_SESSION['user']['role'] === 'admin'): ?>
          <a href="/WMSTAY/admin/dashboard.php">Dashboard</a>
          <a href="/WMSTAY/admin/manage_rooms.php">Rooms</a>
          <a href="/WMSTAY/admin/manage_students.php">Students</a>
          <a href="/WMSTAY/admin/maintenance_requests.php">Maintenance</a>
        <?php else: ?>
          <a href="/WMSTAY/student/dashboard.php">Dashboard</a>
          <a href="/WMSTAY/student/profile.php">Profile</a>
          <a href="/WMSTAY/student/maintenance.php">Maintenance</a>
        <?php endif; ?>
        <a href="/WMSTAY/logout.php" class="logout">Logout</a>
      <?php else: ?>
        <a href="/WMSTAY/index.php">Login</a>
        <a href="/WMSTAY/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </aside>
  <main class="main">
    <header class="topbar">
      <button id="btnToggle" class="btn-toggle">☰</button>
      <div class="topbar-title"><?= htmlspecialchars($title) ?></div>
      <div class="topbar-right">
        <?php if(isset($_SESSION['user'])): ?>
          <span class="user-chip"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
        <?php endif; ?>
      </div>
    </header>
    <section class="content">