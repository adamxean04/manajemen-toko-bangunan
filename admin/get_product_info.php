<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Pastikan parameter ID produk ada dan bukan null
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Query untuk mengambil harga dan stok produk berdasarkan ID
    $query_produk_info = "SELECT hargaproduk, stokproduk FROM produk WHERE idproduk = '$productId'";
    $result_produk_info = mysqli_query($conn, $query_produk_info);

    if ($result_produk_info) {
        $row_produk_info = mysqli_fetch_assoc($result_produk_info);
        // Mengembalikan data dalam format JSON
        echo json_encode($row_produk_info);
    } else {
        echo json_encode(['error' => 'Query error: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['error' => 'ID produk tidak ditemukan']);
}
?>