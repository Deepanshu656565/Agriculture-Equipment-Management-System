<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';

$counts = [
  'users' => $conn->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch_assoc()['c'],
  'equipment' => $conn->query("SELECT COUNT(*) c FROM equipment")->fetch_assoc()['c'],
  'bookings' => $conn->query("SELECT COUNT(*) c FROM bookings")->fetch_assoc()['c'],
  'pending' => $conn->query("SELECT COUNT(*) c FROM bookings WHERE status='pending'")->fetch_assoc()['c'],
];
?>
<h1 class="mb-4">Admin Dashboard</h1>
<div class="row g-3">
  <div class="col-md-3"><div class="card card-body text-center shadow-sm"><div class="display-6"><?= $counts['users'] ?></div><div>Users</div></div></div>
  <div class="col-md-3"><div class="card card-body text-center shadow-sm"><div class="display-6"><?= $counts['equipment'] ?></div><div>Equipment</div></div></div>
  <div class="col-md-3"><div class="card card-body text-center shadow-sm"><div class="display-6"><?= $counts['bookings'] ?></div><div>Total Bookings</div></div></div>
  <div class="col-md-3"><div class="card card-body text-center shadow-sm"><div class="display-6 text-warning"><?= $counts['pending'] ?></div><div>Pending</div></div></div>
</div>
<div class="mt-4">
  <a href="/agri_rental_full/public/admin/equipment_list.php" class="btn btn-success me-2">Manage Equipment</a>
  <a href="/agri_rental_full/public/admin/bookings.php" class="btn btn-outline-success">Manage Bookings</a>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
