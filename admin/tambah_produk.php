<?php
// Include file konfigurasi untuk koneksi ke database
include "../config.php";

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Inisialisasi variabel untuk menyimpan pesan error
$error = '';

// Memeriksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_produk = $_POST['namaproduk'];
    $harga_produk = $_POST['hargaproduk'];
    $stok_produk = $_POST['stokproduk'];

    // Query untuk menyimpan data ke database
    $query_insert = "INSERT INTO produk (namaproduk, hargaproduk, stokproduk) VALUES ('$nama_produk', '$harga_produk', '$stok_produk')";

    if (mysqli_query($conn, $query_insert)) {
        header('Location: data_produk.php');
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin</title>
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

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        .form-label {
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="bg-light">
    <?php include "header.php"; // Memasukkan header untuk admin ?>

    <div class="container mt-3">
        <div class="card shadow form-container">
            <div class="card-body">
                <center>
                    <h2 class="mb-3">Tambah Produk Baru</h2>
                    <form method="POST">
                        <div class="form-row align-items-center mb-3">
                            <div class="col-auto">
                                <label for="namaproduk" class="form-label">Nama Produk :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="namaproduk" name="namaproduk" required>
                            </div>
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-auto">
                                <label for="hargaproduk" class="form-label">Harga Produk :</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="hargaproduk" name="hargaproduk" required>
                            </div>
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-auto">
                                <label for="stokproduk" class="form-label">Stok Produk :</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="stokproduk" name="stokproduk" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="data_produk.php" class="btn btn-secondary">Batal</a>
                        <?php
                        if (!empty($error)) {
                            echo '<div class="alert alert-danger mt-3" role="alert">' . $error . '</div>';
                        }
                        ?>
                    </form>
                </center>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>