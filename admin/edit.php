<?php
include '../database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
  echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href='../login.php';</script>";
  exit;
}

// Update Produk
if (isset($_POST['action']) && $_POST['action'] == "update") {
  $id_produk = mysqli_real_escape_string($kon, $_POST['id_produk']);
  $kode_produk = mysqli_real_escape_string($kon, $_POST['kode_produk']);
  $nama = mysqli_real_escape_string($kon, $_POST['nama']);
  $harga = mysqli_real_escape_string($kon, $_POST['harga']);
  $keterangan = mysqli_real_escape_string($kon, $_POST['keterangan']);
  $stok = mysqli_real_escape_string($kon, $_POST['stok']); // Menambahkan stok
  $query = "UPDATE produk SET kode_produk='$kode_produk', nama='$nama', harga='$harga', keterangan='$keterangan', stok='$stok' WHERE id_produk=$id_produk";
  if (mysqli_query($kon, $query)) {
    echo "<div class='alert alert-success'>Produk berhasil diupdate.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error updating record: " . mysqli_error($kon) . "</div>";
  }
}

?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
  <h3>Update Produk</h3>
  <button onclick="window.location.href='produk.php'" class='btn btn-secondary'>Kembali</button>
  <?php
  $id_produk = isset($_GET['id']) ? $_GET['id'] : '';
  $query = "SELECT * FROM produk WHERE id_produk = $id_produk";
  $result = mysqli_query($kon, $query);
  $data = mysqli_fetch_assoc($result);
  ?>
  <form method="POST" class="form-group">
    <input type="hidden" id="id_produk" name="id_produk" value="<?= $data['id_produk'] ?>">
    <div class="mb-3">
      <label for="kode_produk" class="form-label">Kode Produk:</label>
      <input type="text" id="kode_produk" name="kode_produk" class="form-control" value="<?= $data['kode_produk'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Produk:</label>
      <input type="text" id="nama" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga:</label>
      <input type="number" id="harga" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan:</label>
      <textarea id="keterangan" name="keterangan" class="form-control" required><?= $data['keterangan'] ?></textarea>
    </div>
    <div class="mb-3">
      <label for="stok" class="form-label">Stok:</label>
      <input type="number" id="stok" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
    </div>
    <input type="hidden" name="action" value="update">
    <button type="submit" class="btn btn-primary">Update Produk</button>
  </form>
</div>
