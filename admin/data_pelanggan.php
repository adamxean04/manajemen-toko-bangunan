<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Query untuk mengambil data pelanggan dari tabel pelanggan
$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);

if (!$result_pelanggan) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Admin</title>
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
                <h2 class="mb-3">Data Pelanggan</h2>
                <a href="tambah_pelanggan.php" class="btn btn-primary mb-4">Tambah Pelanggan Baru</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)) {
                            echo '
                            <tr>
                                <td>' . $row_pelanggan['idpelanggan'] . '</td>
                                <td>' . $row_pelanggan['namapelanggan'] . '</td>
                                <td>' . $row_pelanggan['alamatpelanggan'] . '</td>
                                <td>' . $row_pelanggan['teleponpelanggan'] . '</td>
                                <td>
                                    <a href="edit_pelanggan.php?id=' . $row_pelanggan['idpelanggan'] . '" class="btn btn-info btn-sm">Edit</a>
                                    <a href="hapus_pelanggan.php?id=' . $row_pelanggan['idpelanggan'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Anda yakin ingin menghapus pelanggan ini?\')">Hapus</a>
                                </td>
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