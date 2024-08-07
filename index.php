<?php
session_start();
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php?halaman=produk"><strong><span class="glyphicon glyphicon-th-large"></span> Produk</strong></a></li>
          <li><a href="index.php?halaman=keranjang-belanja"><strong><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang Belanja</strong> </a></li>
          <li><a href="logout.php"><strong><span class="glyphicon glyphicon-logout"></span> Logout</strong> </a></li>

        </ul>

      </div>
    </div>
  </div>
</nav>
<div class="container" style="margin-top:80px;">
  <?php
  if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
    switch ($halaman) {
      case 'produk':
        include "produk.php";
        break;
      case 'keranjang-belanja':
        include "keranjang-belanja.php";
        break;
      default:
        echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
        break;
    }
  } else {
    include "produk.php";
  }
  ?>
</div>