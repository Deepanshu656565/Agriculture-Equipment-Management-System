<?php
require_once __DIR__ . '/../includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($user = $res->fetch_assoc()){
        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = [
                'id'=>$user['id'],
                'username'=>$user['username'],
                'email'=>$user['email'],
                'role'=>$user['role']
            ];
            flash('success','Welcome back, '.$user['username'].'!');
            if($user['role']==='admin'){
                redirect('/agri_rental_full/public/admin/index.php');
            }else{
                redirect('/agri_rental_full/public/');
            }
        }
    }
    flash('error','Invalid credentials.');
    redirect('/agri_rental_full/public/login.php');
}
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <h2 class="mb-3">Login</h2>
    <form method="post" class="card card-body shadow-sm">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Login</button>
      <p class="mt-3 small">No account? <a href="/agri_rental_full/public/register.php">Register</a></p>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
