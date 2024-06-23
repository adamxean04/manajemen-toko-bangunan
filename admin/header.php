<?php
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TB Pilar Mas - Admin Dashboard</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="icon" href="../icon.ico" type="image/ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="../assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/responsive.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand px-3 bg-warning" href="#">TB Pilar Mas - Admin </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarC"
                aria-controls="navbarC" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarC">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <span class="text-center d-block pt-2"><i class="fa fa-desktop fa-2x"></i></span>Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data_produk.php">
                            <span class="text-center d-block pt-2"><i class="fa fa-shopping-bag fa-2x"></i></span>Data
                            Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data_laporan.php">
                            <span class="text-center d-block pt-2"><i class="fa fa-folder-open fa-2x"></i></span>Data
                            Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="prediksi.php">
                            <span class="text-center d-block pt-2"><i class="fa fa-chart-bar fa-2x"></i></span>Prediksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data_pelanggan.php">
                            <span class="text-center d-block pt-2"><i class="fa fa-users fa-2x"></i></span>Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php"
                            onclick="return confirm('Anda yakin ingin keluar?');">
                            <span class="text-center d-block pt-2"><i class="fa fa-sign-out-alt fa-2x"></i></span>Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
