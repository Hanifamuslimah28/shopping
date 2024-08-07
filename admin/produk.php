<?php
include '../database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
  echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href='../login.php';</script>";
  exit;
}

// Tampilkan Produk dalam tabel dengan DataTables
$query = "SELECT * FROM produk";
$result = mysqli_query($kon, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar Produk</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      width: 90%;
      margin: 20px auto;
    }

    table {
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <h3>Daftar Produk</h3>
      <button onclick="window.location.href='../logout.php'" class='btn btn-danger'>Logout</button>
    </div>
    <button onclick="window.location.href='tambah.php'" class='btn btn-primary' style='margin-bottom: 10px;'>Tambah Produk</button>
    <div class='table-responsive'>
      <table id='tabelProduk' class='table table-striped table-bordered'>
        <thead class='thead-dark'>
          <tr>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?= $row["kode_produk"] ?></td>
              <td><?= $row["nama"] ?></td>
              <td><?= $row["harga"] ?></td>
              <td><?= $row["stok"] ?></td>
              <td><?= $row["keterangan"] ?></td>
              <td>
                <button onclick="window.location.href='edit.php?id=<?= $row["id_produk"] ?>'">Edit</button> |
                <form method="POST" action="produk.php?action=hapus&id=<?= $row['id_produk'] ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                  <button type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tabelProduk').DataTable();
    });
  </script>
</body>

</html>


<?php
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
  $id_produk = mysqli_real_escape_string($kon, $_GET['id']);
  $query = "DELETE FROM produk WHERE id_produk=?";
  $stmt = mysqli_prepare($kon, $query);
  mysqli_stmt_bind_param($stmt, "i", $id_produk);
  if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Produk dengan ID " . $id_produk . " berhasil dihapus.'); window.location.href='produk.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus produk dengan ID " . $id_produk . ": " . mysqli_error($kon) . "'); window.location.href='produk.php';</script>";
  }
  mysqli_stmt_close($stmt);
}
?>


