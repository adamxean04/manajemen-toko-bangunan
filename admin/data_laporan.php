<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Query untuk mengambil data transaksi dari tabel transaksi
$query_transaksi = "
    SELECT t.idtransaksi, p.namapelanggan, t.tanggal, t.total
    FROM transaksi t
    JOIN pelanggan p ON t.idpelanggan = p.idpelanggan
";
$result_transaksi = mysqli_query($conn, $query_transaksi);

if (!$result_transaksi) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Penjualan - Admin</title>
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
                <h2 class="mb-3">Laporan Penjualan</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row_transaksi = mysqli_fetch_assoc($result_transaksi)) {
                            echo '
                            <tr>
                                <td>' . $row_transaksi['idtransaksi'] . '</td>
                                <td>' . $row_transaksi['namapelanggan'] . '</td>
                                <td>' . $row_transaksi['tanggal'] . '</td>
                                <td>' . number_format($row_transaksi['total'], 2, ',', '.') . '</td>
                                <td><a href="detail_laporan.php?idtransaksi=' . $row_transaksi['idtransaksi'] . '" class="btn btn-info btn-sm">Lihat Detail</a></td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
