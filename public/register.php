<?php
require_once __DIR__ . '/../includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpass = $_POST['confirm_password'] ?? '';

    if($password !== $cpass){
        flash('error','Passwords do not match.');
        redirect('/agri_rental_full/public/register.php');
    }
    // Unique email check
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if($stmt->get_result()->num_rows>0){
        flash('error','Email already registered.');
        redirect('/agri_rental_full/public/register.php');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';
    $stmt = $conn->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,?)");
    $stmt->bind_param('ssss', $username, $email, $hash, $role);
    if($stmt->execute()){
        flash('success','Registration successful. Please login.');
        redirect('/agri_rental_full/public/login.php');
    } else {
        flash('error','Registration failed.');
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-3">Create an Account</h2>
    <form method="post" class="card card-body shadow-sm">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Register</button>
      <p class="mt-3 small">Already have an account? <a href="/agri_rental_full/public/login.php">Login</a></p>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
