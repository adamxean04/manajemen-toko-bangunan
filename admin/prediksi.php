<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prediksi Stok</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <?php include 'template/header.php'; ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <div class="col-md-4">
                    <label for="jenis_produk">Produk:</label>
                    <select class="form-control" id="jenis_produk">
                        <option value="" selected disabled>Pilih Produk</option>
                        <?php
                        include 'config.php';
                        $query = "SELECT idproduk, nama_produk FROM produk";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $produk_id = $row['idproduk'];
                                $produk_nama = $row['nama_produk'];
                                echo "<option value='$produk_id'>$produk_nama</option>";
                            }
                        } else {
                            echo "<option>Error</option>";
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Bulan</th>
                        <th>Terjual</th>
                        <th>Prediksi</th>
                    </tr>
                </thead>
                <tbody id="tabel_produk">
                    <!-- Isi tabel akan di-generate menggunakan JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>

    <script>
        // Ketika pilihan produk diubah
        document.getElementById("jenis_produk").addEventListener("change", function () {
            var produkId = this.value;
            var tbody = document.getElementById("tabel_produk");
            tbody.innerHTML = ""; // Kosongkan tabel

            // Kirim permintaan AJAX untuk mengambil data terjual dan menampilkan di tabel
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "proses_prediksi.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    tbody.innerHTML = response; // Isi tabel dengan data yang diterima dari server
                }
            };
            xhr.send("produk_id=" + encodeURIComponent(produkId)); // Kirim id produk ke server
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var table = $('#table').DataTable();

            // Sembunyikan pesan "Showing 0 to 0 of 0 entries" jika tabel kosong
            if ($('#tabel_produk').is(':empty')) {
                table.destroy(); // Hapus plugin DataTables
                $('#table_info').hide(); // Sembunyikan pesan info
                $('#table_paginate').hide(); // Sembunyikan navigasi halaman
            }
        });
    </script>

</body>

</html>