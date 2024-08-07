<?php
include '../database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
  echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href='../login.php';</script>";
  exit;
}

// Tambah Produk
if (isset($_POST['action']) && $_POST['action'] == "tambah") {
  $kode_produk = mysqli_real_escape_string($kon, $_POST['kode_produk']);
  $nama = mysqli_real_escape_string($kon, $_POST['nama']);
  $harga = mysqli_real_escape_string($kon, $_POST['harga']);
  $keterangan = mysqli_real_escape_string($kon, $_POST['keterangan']);
  $stok = mysqli_real_escape_string($kon, $_POST['stok']); // Menambahkan stok
  $nama_gambar = $_FILES['gambar']['name'];
  $lokasi_gambar = $_FILES['gambar']['tmp_name'];
  $folder = "../gambar/";
  move_uploaded_file($lokasi_gambar, $folder . $nama_gambar);
  $query = "INSERT INTO produk (kode_produk, nama, harga, keterangan, gambar, stok) VALUES ('$kode_produk', '$nama', '$harga', '$keterangan', '$nama_gambar', '$stok')";
  if (mysqli_query($kon, $query)) {
    echo "<div class='alert alert-success'>Produk baru berhasil ditambahkan.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: " . $query . "<br>" . mysqli_error($kon) . "</div>";
  }
}

?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
  <h3 class="mb-3">Tambah Produk</h3>
  <button onclick="window.location.href='produk.php'" class='btn btn-secondary'>Kembali</button>
  <form method="POST" class="form-group" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="kode_produk" class="form-label">Kode Produk:</label>
      <input type="text" id="kode_produk" name="kode_produk" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Produk:</label>
      <input type="text" id="nama" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga:</label>
      <input type="number" id="harga" name="harga" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan:</label>
      <textarea id="keterangan" name="keterangan" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label for="stok" class="form-label">Stok:</label> <!-- Menambahkan input untuk stok -->
      <input type="number" id="stok" name="stok" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="gambar" class="form-label">Gambar Produk:</label>
      <input type="file" id="gambar" name="gambar" class="form-control" required>
    </div>
    <input type="hidden" name="action" value="tambah">
    <button type="submit" class="btn btn-primary">Tambah Produk</button>
  </form>
</div>