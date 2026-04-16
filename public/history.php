<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$uid = $_SESSION['user']['id'];
$sql = "SELECT b.*, e.name AS equipment_name FROM bookings b
        JOIN equipment e ON e.id=b.equipment_id
        WHERE b.user_id = ? ORDER BY b.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $uid);
$stmt->execute();
$rows = $stmt->get_result();
?>
<h1 class="mb-3">My Rental History</h1>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr>
    <th>#</th><th>Equipment</th><th>Start</th><th>End</th><th>Days</th><th>Total (₹)</th><th>Status</th><th>Booked On</th>
  </tr></thead>
  <tbody>
  <?php $i=1; while($r=$rows->fetch_assoc()): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= e($r['equipment_name']) ?></td>
      <td><?= e($r['start_date']) ?></td>
      <td><?= e($r['end_date']) ?></td>
      <td><?= (new DateTime($r['start_date']))->diff(new DateTime($r['end_date']))->days + 1 ?></td>
      <td><?= e($r['total_price']) ?></td>
      <td><span class="badge bg-<?php echo $r['status']=='approved'?'success':($r['status']=='rejected'?'danger':'warning'); ?>"><?= e(ucfirst($r['status'])) ?></span></td>
      <td><?= e($r['created_at']) ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
