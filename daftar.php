<?php
include 'database.php'; // Pastikan untuk mengganti dengan path yang benar ke file koneksi database Anda

$error = '';
$success = '';

// Proses pendaftaran ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = mysqli_real_escape_string($kon, $_POST['nama']);
  $email = mysqli_real_escape_string($kon, $_POST['email']);
  $password = mysqli_real_escape_string($kon, $_POST['password']);
  $alamat = mysqli_real_escape_string($kon, $_POST['alamat']);
  $telepon = mysqli_real_escape_string($kon, $_POST['telepon']);

  if (!empty($email) && !empty($password) && !empty($nama)) {
    // Cek jika email sudah terdaftar
    $cek_email = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($kon, $cek_email);
    if (mysqli_num_rows($result) > 0) {
      $error = 'Email sudah terdaftar!';
    } else {
      // Enkripsi kata sandi
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      // Menyimpan data user ke database
      $query = "INSERT INTO users (nama, email, password, alamat, telepon) VALUES ('$nama', '$email', '$password_hash', '$alamat', '$telepon')";
      if (mysqli_query($kon, $query)) {
        $success = 'Pendaftaran berhasil! Silakan <a href="login.php">login</a>.';
      } else {
        $error = 'Pendaftaran gagal!';
      }
    }
  } else {
    $error = 'Mohon isi semua kolom yang wajib!';
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2>Daftar</h2>
          </div>
          <div class="card-body">
            <?php if ($error) : ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endif; ?>
            <?php if ($success) : ?>
              <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
              </div>
            <?php endif; ?>
            <form method="POST" action="daftar.php">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea class="form-control" id="alamat" name="alamat"></textarea>
              </div>
              <div class="mb-3">
                <label for="telepon" class="form-label">Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="telepon">
              </div>
              <button type="submit" class="btn btn-primary">Daftar</button>
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