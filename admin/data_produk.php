<?php
// Include file konfigurasi untuk koneksi ke database
include "../config.php";

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Query untuk mengambil data produk dari tabel produk
$query_produk = "SELECT * FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

if (!$result_produk) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Admin</title>
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

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-3">Data Produk</h2>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <a href="tambah_produk.php" class="btn btn-primary btn-sm">Tambah Produk Baru</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row_produk = mysqli_fetch_assoc($result_produk)) {
                            echo '<tr>';
                            echo '<td>' . $row_produk['idproduk'] . '</td>';
                            echo '<td>' . $row_produk['namaproduk'] . '</td>';
                            echo '<td>Rp. ' . number_format($row_produk['hargaproduk']) . '</td>';
                            echo '<td>' . $row_produk['stokproduk'] . '</td>';
                            echo '<td>';
                            echo '<a href="edit_produk.php?id=' . $row_produk['idproduk'] . '" class="btn btn-info btn-sm mr-1">Edit</a>';
                            echo '<a href="hapus_produk.php?id=' . $row_produk['idproduk'] . '" class="btn btn-danger btn-sm">Hapus</a>';
                            echo '</td>';
                            echo '</tr>';
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
