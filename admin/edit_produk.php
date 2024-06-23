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

// Memeriksa apakah parameter id produk telah diberikan
if (!isset($_GET['id'])) {
    header('Location: data_produk.php');
    exit();
}

$id_produk = $_GET['id'];

// Query untuk mengambil data produk berdasarkan id
$query_produk = "SELECT * FROM produk WHERE idproduk = $id_produk";
$result_produk = mysqli_query($conn, $query_produk);

if (!$result_produk || mysqli_num_rows($result_produk) == 0) {
    header('Location: data_produk.php');
    exit();
}

$row_produk = mysqli_fetch_assoc($result_produk);

// Memeriksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_produk = $_POST['namaproduk'];
    $harga_produk = $_POST['hargaproduk'];
    $stok_produk = $_POST['stokproduk'];

    // Query untuk mengupdate data produk
    $query_update = "UPDATE produk SET namaproduk = '$nama_produk', hargaproduk = '$harga_produk', stokproduk = '$stok_produk' WHERE idproduk = $id_produk";

    if (mysqli_query($conn, $query_update)) {
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
    <title>Edit Produk - Admin</title>
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
                <h2 class="mb-3">Edit Produk</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="namaproduk">Nama Produk</label>
                        <input type="text" class="form-control" id="namaproduk" name="namaproduk"
                            value="<?php echo $row_produk['namaproduk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hargaproduk">Harga Produk</label>
                        <input type="number" class="form-control" id="hargaproduk" name="hargaproduk"
                            value="<?php echo $row_produk['hargaproduk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stokproduk">Stok Produk</label>
                        <input type="number" class="form-control" id="stokproduk" name="stokproduk"
                            value="<?php echo $row_produk['stokproduk']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="data_produk.php" class="btn btn-secondary">Batal</a>
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