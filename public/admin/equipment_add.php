<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price_per_day'] ?? 0);
    $status = $_POST['status'] ?? 'available';
    $image_path = '';

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fname = 'assets/img/'.time().'_'.rand(1000,9999).'.'.$ext;
        $dest = __DIR__ . '/../../' . $fname;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $dest)){
            $image_path = $fname;
        }
    }

    $stmt = $conn->prepare("INSERT INTO equipment(name,type,description,price_per_day,status,image) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param('ssssss', $name, $type, $description, $price, $status, $image_path);
    if($stmt->execute()){
        flash('success','Equipment added.');
        redirect('/agri_rental_full/public/admin/equipment_list.php');
    }else{
        flash('error','Failed to add equipment.');
    }
}
?>
<h1 class="mb-3">Add Equipment</h1>
<form class="card card-body shadow-sm" method="post" enctype="multipart/form-data">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Type</label>
      <input class="form-control" name="type" required>
    </div>
    <div class="col-12">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3"></textarea>
    </div>
    <div class="col-md-4">
      <label class="form-label">Price per Day (₹)</label>
      <input type="number" step="0.01" class="form-control" name="price_per_day" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <option value="available">available</option>
        <option value="unavailable">unavailable</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Image</label>
      <input type="file" class="form-control" name="image" accept="image/*">
    </div>
  </div>
  <button class="btn btn-success mt-3">Save</button>
  <a href="/agri_rental_full/public/admin/equipment_list.php" class="btn btn-outline-secondary mt-3">Cancel</a>
</form>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
