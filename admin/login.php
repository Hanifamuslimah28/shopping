<?php
session_start();
include '../database.php'; // Pastikan untuk mengganti dengan path yang benar ke file koneksi database Anda

$error = '';

// Proses login ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($kon, $_POST['email']);
  $password = mysqli_real_escape_string($kon, $_POST['password']);

  if (!empty($email) && !empty($password)) {
    // Mencari user di database
    $query = "SELECT id, password, level FROM users WHERE email = '$email'";
    $result = mysqli_query($kon, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
      // Set session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['level'] = $user['level'];
      if ($_SESSION['level'] == 'admin') {
        // Arahkan ke dashboard admin
        header('Location: /shopping_cart/admin/produk.php');
        exit;
      } else {
        // Arahkan pengguna biasa ke halaman keranjang belanja
        header('Location: ../index.php');
        exit;
      }
    } else {
      $error = 'Email atau kata sandi salah!';
    }
  } else {
    $error = 'Email dan kata sandi harus diisi!';
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2>Login</h2>
          </div>
          <div class="card-body">
            <?php if ($error) : ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endif; ?>
            <form method="POST" action="login.php">
              <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
              <button class="btn btn-primary">Daftar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>