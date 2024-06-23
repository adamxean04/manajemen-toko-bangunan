<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

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
    $nama_pelanggan = $_POST['namapelanggan'];
    $alamat_pelanggan = $_POST['alamatpelanggan'];
    $telepon_pelanggan = $_POST['teleponpelanggan'];

    // Query untuk menyimpan data ke database
    $query_insert = "INSERT INTO pelanggan (namapelanggan, alamatpelanggan, teleponpelanggan) 
                     VALUES ('$nama_pelanggan', '$alamat_pelanggan', '$telepon_pelanggan')";

    if (mysqli_query($conn, $query_insert)) {
        header('Location: data_pelanggan.php');
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
    <title>Tambah Pelanggan Baru - Admin</title>
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
        <div class="card shadow mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <center>
                    <h2 class="mb-3">Tambah Pelanggan Baru</h2>
                    <form method="POST">
                        <div class="form-group row align-items-center mb-3">
                            <label for="namapelanggan" class="col-md-4 col-form-label text-md-right">Nama Pelanggan
                                :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="namapelanggan" name="namapelanggan"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row align-items-center mb-3">
                            <label for="alamatpelanggan" class="col-md-4 col-form-label text-md-right">Alamat Pelanggan
                                :</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="alamatpelanggan" name="alamatpelanggan"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row align-items-center mb-3">
                            <label for="teleponpelanggan" class="col-md-4 col-form-label text-md-right">Telepon Pelanggan :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teleponpelanggan" name="teleponpelanggan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="data_pelanggan.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
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