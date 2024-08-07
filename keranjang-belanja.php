<?php
if (isset($_GET['kode_produk']) && isset($_GET['jumlah'])) {

    $kode_produk = $_GET['kode_produk'];
    $jumlah = $_GET['jumlah'];

    include 'database.php';

    $sql = "select * from produk where kode_produk='$kode_produk'";

    $query = mysqli_query($kon, $sql);
    $data = mysqli_fetch_array($query);
    $kode_produk = $data['kode_produk'];
    $nama_produk = $data['nama'];
    $harga = $data['harga'];
    $stok = $data['stok'];
} else {
    $kode_produk = "";
    $jumlah = 0;
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
} else {
    $aksi = "";
}


switch ($aksi) {
        //Fungsi untuk menambah penyewaan kedalam cart
    case "tambah_produk":
        $itemArray = array($kode_produk => array('kode_produk' => $kode_produk, 'nama_produk' => $nama_produk, 'jumlah' => $jumlah, 'harga' => $harga, 'stok' => $stok));
        if (!empty($_SESSION["keranjang_belanja"])) {
            if (in_array($data['kode_produk'], array_keys($_SESSION["keranjang_belanja"]))) {
                foreach ($_SESSION["keranjang_belanja"] as $k => $v) {
                    if ($data['kode_produk'] == $k) {
                        $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
                    }
                }
            } else {
                $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
            }
        } else {
            $_SESSION["keranjang_belanja"] = $itemArray;
        }
        break;
        //Fungsi untuk menghapus item dalam cart
    case "hapus":

        if (!empty($_SESSION["keranjang_belanja"])) {
            foreach ($_SESSION["keranjang_belanja"] as $k => $v) {
                if ($_GET["kode_produk"] == $k)
                    unset($_SESSION["keranjang_belanja"][$k]);
                if (empty($_SESSION["keranjang_belanja"]))
                    unset($_SESSION["keranjang_belanja"]);
            }
        }
        break;

    case "update":
        $itemArray = array($kode_produk => array('kode_produk' => $kode_produk, 'nama_produk' => $nama_produk, 'jumlah' => $jumlah, 'harga' => $harga));
        if (!empty($_SESSION["keranjang_belanja"])) {
            foreach ($_SESSION["keranjang_belanja"] as $k => $v) {
                if ($_GET["kode_produk"] == $k)
                    $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
            }
        }
        break;
}
?>

<div class="row">
    <h2 style="margin-bottom:30px;">Keranjang Belanja</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th width="40%">Nama</th>
                <th>Harga</th>
                <th width="10%">QTY</th>
                <th>Sub Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $sub_total = 0;
            $total = 0;
            $total_berat = 0;
            if (!empty($_SESSION["keranjang_belanja"])) :
                foreach ($_SESSION["keranjang_belanja"] as $item) :
                    $no++;
                    $sub_total = $item["jumlah"] * $item['harga'];
                    $total += $sub_total;
            ?>
                    <input type="hidden" name="kode_produk[]" class="kode_produk" value="<?php echo $item["kode_produk"]; ?>" />
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $item["kode_produk"]; ?></td>
                        <td><?php echo $item["nama_produk"]; ?></td>
                        <td>Rp. <?php echo number_format($item["harga"], 0, ',', '.'); ?> </td>
                        <td>
                            <input type="number" min="1" value="<?php echo $item["jumlah"]; ?>" class="form-control" id="jumlah<?php echo $no; ?>" name="jumlah[]">
                            <script>
                                $("#jumlah<?php echo $no; ?>").bind('change', function() {
                                    var jumlah<?php echo $no; ?> = $("#jumlah<?php echo $no; ?>").val();
                                    $("#jumlaha<?php echo $no; ?>").val(jumlah<?php echo $no; ?>);
                                });
                                $("#jumlah<?php echo $no; ?>").keydown(function(event) {
                                    return false;
                                });
                            </script>

                        </td>
                        <td>Rp. <?php echo number_format($sub_total, 0, ',', '.'); ?> </td>

                        <td>
                            <form method="get">
                                <input type="hidden" name="kode_produk" value="<?php echo $item['kode_produk']; ?>" class="form-control">
                                <input type="hidden" name="aksi" value="update" class="form-control">
                                <input type="hidden" name="halaman" value="keranjang-belanja" class="form-control">
                                <input type="hidden" name="jumlah" value="<?php echo $item["jumlah"]; ?>" id="jumlaha<?php echo $no; ?>" value="" class="form-control">
                                <input type="submit" class="btn btn-warning btn-xs" value="Update">
                            </form>
                            <a href="index.php?halaman=keranjang-belanja&kode_produk=<?php echo $item['kode_produk']; ?>&aksi=hapus" class="btn btn-danger btn-xs" role="button">Delete</a>
                        </td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    <h3>Total Pembayaran Rp. <?php echo number_format($total, 0, ',', '.'); ?>
        <?php if (isset($_SESSION['user_login'])): ?>
            <form method="post" action="proses_transaksi.php">
                <button type="submit" class="btn btn-success">Bayar Sekarang</button>
            </form>
        <?php else: ?>
            <button onclick="location.href='login.php';" class="btn btn-success">Bayar Sekarang</button>
        <?php endif; ?>
    </h3>
</div>