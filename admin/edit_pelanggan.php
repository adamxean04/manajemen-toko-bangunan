<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Inisialisasi variabel untuk menyimpan pesan error
$error = '';

// Memeriksa apakah parameter id telah dikirim melalui URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_pelanggan = $_GET['id'];

    // Query untuk mengambil data pelanggan berdasarkan id
    $query_select = "SELECT * FROM pelanggan WHERE idpelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query_select);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    // Memeriksa apakah data pelanggan ditemukan
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $nama_pelanggan = $data['namapelanggan'];
        $alamat_pelanggan = $data['alamatpelanggan'];
        $telepon_pelanggan = $data['teleponpelanggan'];
    } else {
        // Jika data pelanggan tidak ditemukan, redirect ke halaman data_pelanggan.php
        header('Location: data_pelanggan.php');
        exit();
    }
} else {
    // Jika parameter id tidak ada atau kosong, redirect ke halaman data_pelanggan.php
    header('Location: data_pelanggan.php');
    exit();
}

// Memeriksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_pelanggan_baru = $_POST['namapelanggan'];
    $alamat_pelanggan_baru = $_POST['alamatpelanggan'];
    $telepon_pelanggan_baru = $_POST['teleponpelanggan'];

    // Query untuk melakukan update data pelanggan
    $query_update = "UPDATE pelanggan SET namapelanggan = '$nama_pelanggan_baru', alamatpelanggan = '$alamat_pelanggan_baru', teleponpelanggan = '$telepon_pelanggan_baru' WHERE idpelanggan = '$id_pelanggan'";

    if (mysqli_query($conn, $query_update)) {
        // Redirect ke halaman data_pelanggan.php jika update berhasil
        header('Location: data_pelanggan.php');
        exit();
    } else {
        // Jika terjadi error saat menjalankan query update
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - Admin</title>
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
                <h2 class="mb-3">Edit Pelanggan</h2>
                <form method="POST">
                    <div class="form-row align-items-center mb-3">
                        <div class="col-auto">
                            <label for="namapelanggan" class="form-label">Nama Pelanggan :</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="namapelanggan" name="namapelanggan"
                                value="<?php echo $nama_pelanggan; ?>" required>
                        </div>
                    </div>
                    <div class="form-row align-items-center mb-3">
                        <div class="col-auto">
                            <label for="alamatpelanggan" class="form-label">Alamat Pelanggan :</label>
                        </div>
                        <div class="col">
                            <textarea class="form-control" id="alamatpelanggan" name="alamatpelanggan"
                                rows="3"><?php echo $alamat_pelanggan; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row align-items-center mb-3">
                        <div class="col-auto">
                            <label for="teleponpelanggan" class="form-label">Telepon Pelanggan :</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="teleponpelanggan" name="teleponpelanggan"
                                value="<?php echo $telepon_pelanggan; ?>">
                        </div>
                    </div>
                    <center>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="data_pelanggan.php" class="btn btn-secondary">Batal</a>
                    </div>
                    </center>
                    <?php
                    if (!empty($error)) {
                        echo '<div class="alert alert-danger mt-3" role="alert">' . $error . '</div>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>