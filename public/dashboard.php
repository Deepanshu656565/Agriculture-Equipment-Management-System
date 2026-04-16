<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$uid = $_SESSION['user']['id'];
$total = $conn->query("SELECT COUNT(*) c FROM bookings WHERE user_id={$uid}")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) c FROM bookings WHERE user_id={$uid} AND status='pending'")->fetch_assoc()['c'];
$approved = $conn->query("SELECT COUNT(*) c FROM bookings WHERE user_id={$uid} AND status='approved'")->fetch_assoc()['c'];
?>
<h1 class="mb-4">My Dashboard</h1>
<div class="row g-3">
  <div class="col-md-4"><div class="card card-body text-center shadow-sm"><div class="display-6"><?= $total ?></div><div>Total Bookings</div></div></div>
  <div class="col-md-4"><div class="card card-body text-center shadow-sm"><div class="display-6 text-warning"><?= $pending ?></div><div>Pending</div></div></div>
  <div class="col-md-4"><div class="card card-body text-center shadow-sm"><div class="display-6 text-success"><?= $approved ?></div><div>Approved</div></div></div>
</div>
<p class="mt-4"><a href="/agri_rental_full/public/history.php" class="btn btn-outline-success">View Rental History</a></p>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
