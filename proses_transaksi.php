<?php
session_start();
include 'database.php';

if (!empty($_SESSION["keranjang_belanja"])) {
  if (isset($_SESSION['user_id'])) { // Memastikan bahwa 'user' dan 'user_id' ada
    $user_id = $_SESSION['user_id']; // Menetapkan user_id dari sesi
    $total = 0;

    foreach ($_SESSION["keranjang_belanja"] as $item) {
      $total += $item["jumlah"] * $item["harga"];
    }

    // Menyimpan transaksi ke database dengan id_user
    $query = "INSERT INTO transaksi (user_id, total_bayar, status) VALUES ('$user_id', '$total', 'Diproses')";
    $result = mysqli_query($kon, $query);
    $id_transaksi = mysqli_insert_id($kon); // Mendapatkan ID transaksi yang baru dibuat

    if ($result) {
      // Menyimpan detail transaksi
      foreach ($_SESSION["keranjang_belanja"] as $item) {
        $kode_produk = $item['kode_produk'];
        $nama_produk = $item['nama_produk'];
        $jumlah = $item['jumlah'];
        $harga = $item['harga'];
        $sub_total = $jumlah * $harga;

        $query_detail = "INSERT INTO detail_transaksi (id_transaksi, kode_produk, nama_produk, jumlah, harga, sub_total) VALUES ('$id_transaksi', '$kode_produk', '$nama_produk', '$jumlah', '$harga', '$sub_total')";
        mysqli_query($kon, $query_detail);
      }

      // Kosongkan keranjang belanja
      unset($_SESSION["keranjang_belanja"]);
      echo "<script>alert('Pembayaran berhasil!'); window.location.href='index.php';</script>";
    } else {
      echo "<script>alert('Pembayaran gagal!'); window.location.href='keranjang-belanja.php';</script>";
    }
  } else {
    echo "<script>alert('Pengguna tidak teridentifikasi. Silakan login.'); window.location.href='login.php';</script>";
  }
} else {
  echo "<script>alert('Keranjang belanja kosong!'); window.location.href='index.php/index.php?halaman=keranjang-belanja';</script>";
}
?>
?>