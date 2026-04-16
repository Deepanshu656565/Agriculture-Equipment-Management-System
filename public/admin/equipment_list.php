<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';

$res = $conn->query("SELECT * FROM equipment ORDER BY created_at DESC");
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Equipment</h1>
  <a href="/agri_rental_full/public/admin/equipment_add.php" class="btn btn-success">Add Equipment</a>
</div>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr>
    <th>#</th><th>Name</th><th>Type</th><th>Price/Day</th><th>Status</th><th>Actions</th>
  </tr></thead>
  <tbody>
  <?php $i=1; while($row=$res->fetch_assoc()): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= e($row['name']) ?></td>
      <td><?= e($row['type']) ?></td>
      <td>₹<?= e($row['price_per_day']) ?></td>
      <td><?= e(ucfirst($row['status'])) ?></td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="/agri_rental_full/public/admin/equipment_edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item?')" href="/agri_rental_full/public/admin/equipment_delete.php?id=<?= $row['id'] ?>">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
