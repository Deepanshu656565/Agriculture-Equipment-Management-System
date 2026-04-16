<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM equipment WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
if(!$item){
    flash('error','Equipment not found.');
    redirect('/agri_rental_full/public/admin/equipment_list.php');
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price_per_day'] ?? 0);
    $status = $_POST['status'] ?? 'available';
    $image_path = $item['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fname = 'assets/img/'.time().'_'.rand(1000,9999).'.'.$ext;
        $dest = __DIR__ . '/../../' . $fname;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $dest)){
            $image_path = $fname;
        }
    }

    $stmt = $conn->prepare("UPDATE equipment SET name=?, type=?, description=?, price_per_day=?, status=?, image=? WHERE id=?");
    $stmt->bind_param('ssssssi', $name, $type, $description, $price, $status, $image_path, $id);
    if($stmt->execute()){
        flash('success','Equipment updated.');
        redirect('/agri_rental_full/public/admin/equipment_list.php');
    }else{
        flash('error','Update failed.');
    }
}
?>
<h1 class="mb-3">Edit Equipment</h1>
<form class="card card-body shadow-sm" method="post" enctype="multipart/form-data">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="<?= e($item['name']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Type</label>
      <input class="form-control" name="type" value="<?= e($item['type']) ?>" required>
    </div>
    <div class="col-12">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3"><?= e($item['description']) ?></textarea>
    </div>
    <div class="col-md-4">
      <label class="form-label">Price per Day (₹)</label>
      <input type="number" step="0.01" class="form-control" name="price_per_day" value="<?= e($item['price_per_day']) ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <option value="available" <?= $item['status']=='available'?'selected':'' ?>>available</option>
        <option value="unavailable" <?= $item['status']=='unavailable'?'selected':'' ?>>unavailable</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Image</label>
      <input type="file" class="form-control" name="image" accept="image/*">
      <?php if($item['image']): ?>
        <img src="/agri_rental_full/<?= e($item['image']) ?>" class="img-thumbnail mt-2" style="max-height:120px">
      <?php endif; ?>
    </div>
  </div>
  <button class="btn btn-success mt-3">Update</button>
  <a href="/agri_rental_full/public/admin/equipment_list.php" class="btn btn-outline-secondary mt-3">Cancel</a>
</form>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
