<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM equipment WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if(!$item){
    flash('error','Equipment not found.');
    redirect('/agri_rental_full/public/');
}
?>

<div class="row g-4">
  <div class="col-md-6">
    <img class="img-fluid rounded shadow-sm" src="/agri_rental_full/public/images/<?= $item['image'] ? e($item['image']) : 'tractor_45hp.jpeg' ?>" alt="<?= e($item['name']) ?>">
  </div>
  
  <div class="col-md-6">
    <h2><?= e($item['name']) ?></h2>
    <p class="text-muted"><?= nl2br(e($item['description'])) ?></p>
    <p><span class="badge bg-success">₹<?= e($item['price_per_day']) ?>/day</span></p>

    <?php if(is_logged_in()): ?>
    <form method="post" action="/agri_rental_full/public/book.php" class="card card-body shadow-sm">
      <input type="hidden" name="equipment_id" value="<?= $item['id'] ?>">
      
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Start Date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">End Date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" required>
        </div>
      </div>
      
      <button class="btn btn-success mt-3">Book Now</button>
    </form>
    
    <?php else: ?>
      <div class="alert alert-info">Please <a href="/agri_rental_full/public/login.php">login</a> to book.</div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
