<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idproduk = $_POST['idproduk'];

    // Query untuk mengambil data produk berdasarkan ID produk
    $query_produk = "SELECT namaproduk, hargaproduk, stokproduk FROM produk WHERE idproduk = ?";
    $stmt = mysqli_prepare($conn, $query_produk);
    mysqli_stmt_bind_param($stmt, "i", $idproduk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $namaproduk, $hargaproduk, $stokproduk);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);


    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $namaproduk, $hargaproduk, $stokproduk);
        mysqli_stmt_fetch($stmt);

        // Mengembalikan data dalam format JSON
        $response = array(
            'namaproduk' => $namaproduk,
            'hargaproduk' => $hargaproduk,
            'stokproduk' => $stokproduk
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Produk tidak ditemukan.'));
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
