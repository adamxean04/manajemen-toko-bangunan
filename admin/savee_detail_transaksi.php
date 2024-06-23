<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

header('Content-Type: application/json'); // Pastikan header JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $idPelanggan = mysqli_real_escape_string($conn, $data->idpelanggan);
    $tanggal = mysqli_real_escape_string($conn, $data->tanggal);
    $total = mysqli_real_escape_string($conn, $data->total);

    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Masukkan data ke tabel transaksi
        $queryInsertTransaksi = "INSERT INTO transaksi (idpelanggan, tanggal, total) 
                                 VALUES ('$idPelanggan', '$tanggal', '$total')";

        if (!mysqli_query($conn, $queryInsertTransaksi)) {
            throw new Exception('Gagal menyimpan transaksi: ' . mysqli_error($conn));
        }

        $idTransaksiBaru = mysqli_insert_id($conn);

        // Masukkan detail transaksi
        foreach ($data->details as $detail) {
            $idProduk = mysqli_real_escape_string($conn, $detail->idproduk);
            $jumlah = mysqli_real_escape_string($conn, $detail->jumlah);
            $harga = mysqli_real_escape_string($conn, $detail->harga);

            // Validasi apakah produk ada di tabel produk
            $queryCheckProduk = "SELECT COUNT(*) as count FROM produk WHERE idproduk = '$idProduk'";
            $resultCheckProduk = mysqli_query($conn, $queryCheckProduk);
            $rowCheckProduk = mysqli_fetch_assoc($resultCheckProduk);

            if ($rowCheckProduk['count'] == 0) {
                throw new Exception('ID produk tidak valid: ' . $idProduk);
            }

            $queryInsertDetail = "INSERT INTO detail_transaksi (idtransaksi, idproduk, jumlah, harga) 
                                  VALUES ('$idTransaksiBaru', '$idProduk', '$jumlah', '$harga')";
            if (!mysqli_query($conn, $queryInsertDetail)) {
                throw new Exception('Gagal menyimpan detail transaksi: ' . mysqli_error($conn));
            }
        }

        // Commit transaksi
        mysqli_commit($conn);

        echo json_encode(['success' => true, 'message' => 'Transaksi berhasil disimpan.', 'idtransaksi' => $idTransaksiBaru]);
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak diizinkan.']);
}
?>