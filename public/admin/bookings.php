<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';

$status = $_GET['status'] ?? 'all';
$where = $status==='all' ? '1' : "b.status='".$conn->real_escape_string($status)."'";
$sql = "SELECT b.*, u.username, e.name AS equipment_name
        FROM bookings b
        JOIN users u ON u.id=b.user_id
        JOIN equipment e ON e.id=b.equipment_id
        WHERE $where
        ORDER BY b.created_at DESC";
$rows = $conn->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Bookings</h1>
  <div>
    <a class="btn btn-sm btn-outline-secondary" href="?status=all">All</a>
    <a class="btn btn-sm btn-outline-warning" href="?status=pending">Pending</a>
    <a class="btn btn-sm btn-outline-success" href="?status=approved">Approved</a>
    <a class="btn btn-sm btn-outline-danger" href="?status=rejected">Rejected</a>
  </div>
</div>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr>
    <th>#</th><th>User</th><th>Equipment</th><th>Start</th><th>End</th><th>Total (₹)</th><th>Status</th><th>Actions</th>
  </tr></thead>
  <tbody>
  <?php $i=1; while($r=$rows->fetch_assoc()): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= e($r['username']) ?></td>
      <td><?= e($r['equipment_name']) ?></td>
      <td><?= e($r['start_date']) ?></td>
      <td><?= e($r['end_date']) ?></td>
      <td><?= e($r['total_price']) ?></td>
      <td><span class="badge bg-<?php echo $r['status']=='approved'?'success':($r['status']=='rejected'?'danger':'warning'); ?>"><?= e(ucfirst($r['status'])) ?></span></td>
      <td>
        <?php if($r['status']=='pending'): ?>
          <a class="btn btn-sm btn-success" href="/agri_rental_full/public/admin/booking_action.php?id=<?= $r['id'] ?>&act=approve">Approve</a>
          <a class="btn btn-sm btn-danger" href="/agri_rental_full/public/admin/booking_action.php?id=<?= $r['id'] ?>&act=reject">Reject</a>
        <?php else: ?>
          -
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
