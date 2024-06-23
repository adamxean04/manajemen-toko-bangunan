<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Memeriksa apakah idtransaksi dikirim melalui parameter GET
if (!isset($_GET['idtransaksi'])) {
    header('Location: data_laporan.php');
    exit();
}

$idtransaksi = $_GET['idtransaksi'];

// Query untuk mengambil data transaksi dan pelanggan
$query_transaksi = "
    SELECT t.idtransaksi, p.namapelanggan, t.tanggal, t.total
    FROM transaksi t
    JOIN pelanggan p ON t.idpelanggan = p.idpelanggan
    WHERE t.idtransaksi = '$idtransaksi'
";
$result_transaksi = mysqli_query($conn, $query_transaksi);
$row_transaksi = mysqli_fetch_assoc($result_transaksi);

// Query untuk mengambil detail transaksi
$query_detail = "
    SELECT dt.idproduk, pr.namaproduk, dt.jumlah, dt.harga
    FROM detail_transaksi dt
    JOIN produk pr ON dt.idproduk = pr.idproduk
    WHERE dt.idtransaksi = '$idtransaksi'
";
$result_detail = mysqli_query($conn, $query_detail);

if (!$result_detail) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Penjualan - Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <style>
        body {
            background: url('../assets/img/wp2.jpg') no-repeat center center fixed;
            background-size: cover;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
        }
    </style>
</head>

<body class="bg-light">
    <?php include "header.php"; // Memasukkan header untuk admin ?>

    <div class="container mt-3">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-3">Detail Transaksi</h2>
                <div class="mb-3">
                    <strong>ID Transaksi:</strong> <?php echo $row_transaksi['idtransaksi']; ?><br>
                    <strong>Nama Pelanggan:</strong> <?php echo $row_transaksi['namapelanggan']; ?><br>
                    <strong>Tanggal:</strong> <?php echo $row_transaksi['tanggal']; ?><br>
                    <strong>Total:</strong> <?php echo number_format($row_transaksi['total'], 2, ',', '.'); ?><br>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row_detail = mysqli_fetch_assoc($result_detail)) {
                            echo '
                            <tr>
                                <td>' . $row_detail['idproduk'] . '</td>
                                <td>' . $row_detail['namaproduk'] . '</td>
                                <td>' . $row_detail['jumlah'] . '</td>
                                <td>' . number_format($row_detail['harga'], 2, ',', '.') . '</td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                <a href="data_laporan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>