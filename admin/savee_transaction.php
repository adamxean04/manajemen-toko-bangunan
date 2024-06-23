<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Pastikan ini adalah request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari body request
    $data = json_decode(file_get_contents("php://input"));

    $idPelanggan = mysqli_real_escape_string($conn, $data->idpelanggan);
    $tanggal = mysqli_real_escape_string($conn, $data->tanggal);
    $total = mysqli_real_escape_string($conn, $data->total);

    // Memasukkan data ke tabel transaksi
    $queryInsertTransaksi = "INSERT INTO transaksi (idpelanggan, tanggal, total) 
                            VALUES ('$idPelanggan', '$tanggal', '$total')";

    if (mysqli_query($conn, $queryInsertTransaksi)) {
        // Ambil ID transaksi yang baru saja dimasukkan
        $idTransaksi = mysqli_insert_id($conn);

        // Memasukkan data detail transaksi ke tabel detail_transaksi
        foreach ($data->detail_transaksi as $detail) {
            $idProduk = mysqli_real_escape_string($conn, $detail->idproduk);
            $jumlah = mysqli_real_escape_string($conn, $detail->jumlah);
            $harga = mysqli_real_escape_string($conn, $detail->harga);

            $queryInsertDetail = "INSERT INTO detail_transaksi (idtransaksi, idproduk, jumlah, harga) 
                                  VALUES ('$idTransaksi', '$idProduk', '$jumlah', '$harga')";
            mysqli_query($conn, $queryInsertDetail);
        }

        // Kirim respons ke JavaScript
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>