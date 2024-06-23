<?php
include 'config.php';

$produk_id = $_POST['produk_id'];

// Mendapatkan nama produk
$query_produk = "SELECT nama_produk FROM produk WHERE idproduk = '$produk_id'";
$result_produk = mysqli_query($conn, $query_produk);
if ($result_produk) {
    $row_produk = mysqli_fetch_assoc($result_produk);
    $nama_produk = $row_produk['nama_produk'];
} else {
    echo "Gagal mengambil data produk: " . mysqli_error($conn);
    exit;
}

// Mendapatkan data penjualan 10 bulan terakhir
$query_penjualan = "
    SELECT MONTH(l.tgl_sub) AS bulan, SUM(n.quantity) AS terjual 
    FROM tb_nota n 
    JOIN laporan l ON n.no_nota = l.no_nota 
    WHERE n.idproduk = '$produk_id' 
    AND l.tgl_sub >= DATE_SUB(CURDATE(), INTERVAL 10 MONTH) 
    GROUP BY MONTH(l.tgl_sub)";

$result_penjualan = mysqli_query($conn, $query_penjualan);

$penjualan = array();
if ($result_penjualan) {
    while ($row_penjualan = mysqli_fetch_assoc($result_penjualan)) {
        $penjualan[$row_penjualan['bulan']] = $row_penjualan['terjual'];
    }
} else {
    echo "Gagal mengambil data penjualan: " . mysqli_error($conn);
    exit;
}

// Bangun baris tabel dengan data produk dan penjualan
$html = "";
for ($bulan = 1; $bulan <= 10; $bulan++) {
    $terjual = isset($penjualan[$bulan]) ? $penjualan[$bulan] : 0;
    $prediksi = "Hasil Prediksi"; // Placeholder untuk hasil prediksi

    $html .= "<tr>";
    $html .= "<td>$nama_produk</td>"; // Nama produk
    $html .= "<td>$bulan</td>"; // Nomor bulan
    $html .= "<td>$terjual</td>"; // Terjual
    $html .= "<td>$prediksi</td>"; // Prediksi
    $html .= "</tr>";
}

echo $html;

mysqli_close($conn);
?>