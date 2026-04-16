<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agriculture Equipment Rental</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/agri_rental_full/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/agri_rental_full/public/">AgriRental</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/agri_rental_full/public/">Home</a></li>
        <?php if(is_logged_in()): ?>
          <li class="nav-item"><a class="nav-link" href="/agri_rental_full/public/history.php">My Rentals</a></li>
          <?php if(is_admin()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/agri_rental_full/public/admin/index.php">Dashboard</a></li>
                <li><a class="dropdown-item" href="/agri_rental_full/public/admin/equipment_list.php">Manage Equipment</a></li>
                <li><a class="dropdown-item" href="/agri_rental_full/public/admin/bookings.php">Manage Bookings</a></li>
              </ul>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if(!is_logged_in()): ?>
          <li class="nav-item"><a class="nav-link" href="/agri_rental_full/public/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/agri_rental_full/public/register.php">Register</a></li>
        <?php else: ?>
          <li class="nav-item"><span class="navbar-text me-3">Hi, <?= e($_SESSION['user']['username']) ?></span></li>
          <li class="nav-item"><a class="nav-link" href="/agri_rental_full/public/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
  <?php if($msg = flash('error')): ?>
    <div class="alert alert-danger"><?= e($msg) ?></div>
  <?php endif; ?>
  <?php if($msg = flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
  <?php endif; ?>
