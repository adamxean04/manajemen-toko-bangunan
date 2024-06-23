<?php
include "../config.php"; // Sisipkan file config.php untuk koneksi ke database

// Memeriksa sesi login admin
if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Query untuk mengambil data produk dari tabel produk
$query_produk = "SELECT idproduk, namaproduk, hargaproduk, stokproduk FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

if (!$result_produk) {
    die("Query error: " . mysqli_error($conn));
}

$query_pelanggan = "SELECT idpelanggan, namapelanggan FROM pelanggan";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);

if (!$result_pelanggan) {
    die("Query error: " . mysqli_error($conn));
}

$query_karyawan = "SELECT idkaryawan, namakaryawan FROM karyawan";
$result_karyawan = mysqli_query($conn, $query_karyawan);

if (!$result_karyawan) {
    die("Query error: " . mysqli_error($conn));
}

// Query untuk mengambil data karyawan yang hanya memiliki role 'admin'
$query_karyawan = "SELECT idkaryawan, namakaryawan FROM karyawan WHERE role = 'admin'";
$result_karyawan = mysqli_query($conn, $query_karyawan);

if (!$result_karyawan) {
    die("Query error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Penjualan - Admin</title>
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
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="mb-3">Form Penjualan</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="idpelanggan" class="mb-1">Nama Pelanggan</label>
                                <select class="form-control form-control-sm" id="idpelanggan" name="idpelanggan">
                                    <option value="">Pilih Nama Pelanggan</option>
                                    <?php
                                    while ($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)) {
                                        echo '<option value="' . $row_pelanggan['idpelanggan'] . '">' . $row_pelanggan['namapelanggan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="idkaryawan" class="mb-1">Nama Karyawan</label>
                                <select class="form-control form-control-sm" id="idkaryawan" name="idkaryawan">
                                    <option value="">Pilih Nama Karyawan</option>
                                    <?php
                                    while ($row_karyawan = mysqli_fetch_assoc($result_karyawan)) {
                                        echo '<option value="' . $row_karyawan['idkaryawan'] . '">' . $row_karyawan['namakaryawan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-7">
                                <label for="idproduk" class="mb-1">Produk</label>
                                <select class="form-control form-control-sm" id="idproduk" name="idproduk">
                                    <option value="">Pilih Produk</option>
                                    <?php
                                    while ($row_produk = mysqli_fetch_assoc($result_produk)) {
                                        echo '<option value="' . $row_produk['idproduk'] . '">' . $row_produk['idproduk'] . ' - ' . $row_produk['namaproduk'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <label for="hargaproduk" class="mb-1">Harga</label>
                                <input type="text" class="form-control form-control-sm bg-white" id="hargaproduk" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            
                            <div class="col-lg-4">
                                <label for="stokproduk" class="mb-1">Stok</label>
                                <input type="text" class="form-control form-control-sm bg-white" id="stokproduk" readonly>
                            </div>
                            <div class="col-lg-2">
                                <label for="quantity" class="mb-1">Qty</label>
                                <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" onchange="calculateSubtotal()" placeholder="0" required>
                            </div>
                            <div class="col-lg-2">
                                <label for="subtotal" class="mb-1">Subtotal</label>
                                <input type="text" class="form-control form-control-sm bg-white" id="subtotal" readonly>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-primary btn-sm" id="addProductBtn" onclick="addProduct()">Tambah Produk Beli</button>
                                <button class="btn btn-danger btn-sm" id="resetFormBtn" onclick="resetForm()">Reset</button>
                                <button class="btn btn-success btn-sm" id="saveeTransactionBtn" onclick="saveeTransaction()">Simpan</button>
                                <button class="btn btn-secondary btn-sm" onclick="printNota()">Cetak</button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <h2 class="row mt-3 col-lg-10">List Pesanan</h2>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                        <!-- Baris produk akan ditambahkan di sini melalui JavaScript -->
                                    </tbody>
                                </table>
                                <div class="bg-total p-2 text-right print-none">
                                    <strong>Total: </strong><span id="totalSubtotal">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="mb-3 text-center">Daftar Produk</h2>
                        <div class="product-list">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Produk</th>
                                        <th>Nama Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_produk_list = "SELECT idproduk, namaproduk FROM produk";
                                    $result_produk_list = mysqli_query($conn, $query_produk_list);
                                    while ($row_produk_list = mysqli_fetch_assoc($result_produk_list)) {
                                        echo '<tr>';
                                        echo '<td>' . $row_produk_list['idproduk'] . '</td>';
                                        echo '<td>' . $row_produk_list['namaproduk'] . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProductInfo() {
            var productId = document.getElementById('idproduk').value;
            var url = 'get_product_info.php?id=' + productId;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('hargaproduk').value = formatRupiah(data.hargaproduk);
                    document.getElementById('stokproduk').value = data.stokproduk;
                })
                .catch(error => console.error('Error:', error));
        }

        // Panggil fungsi updateProductInfo saat memilih produk
        document.getElementById('idproduk').addEventListener('change', updateProductInfo);

        function calculateSubtotal() {
            var quantity = parseInt(document.getElementById('quantity').value);
            var hargaInput = document.getElementById('hargaproduk').value;
            
            // Membersihkan nilai harga dari karakter yang tidak diinginkan
            var harga = parseFloat(hargaInput.replace(/[^\d]/g, '')); 
            
            // Pastikan harga adalah angka yang valid
            if (!isNaN(harga)) {
                // Pastikan qty tidak kurang dari 0
                if (quantity < 0) {
                    alert('Quantity tidak boleh kurang dari 0.');
                    document.getElementById('quantity').value = 0;
                    quantity = 0; // Set qty menjadi 0 jika kurang dari 0
                }
                
                var subtotal = (quantity * harga).toFixed(2); // Menetapkan dua desimal
                document.getElementById('subtotal').value = formatRupiah(subtotal);
            } else {
                // Handle jika input harga tidak valid
                alert('Masukkan harga produk dengan format yang benar.');
            }
        }


        function addProduct() {
            var idProduk = document.getElementById('idproduk').value;
            var namaProduk = document.getElementById('idproduk').options[document.getElementById('idproduk').selectedIndex].text;
            var hargaProduk = document.getElementById('hargaproduk').value;
            var stokProduk = document.getElementById('stokproduk').value;
            var quantity = parseInt(document.getElementById('quantity').value);
            var subtotal = parseFloat(hargaProduk.replace(/[^\d]/g, '')) * quantity;

            // Validasi qty tidak boleh kurang dari 0
            if (quantity < 0) {
                alert('Quantity tidak boleh kurang dari 0.');
                return;
            }

            // Tambahkan baris ke tabel list pesanan
            var tableBody = document.getElementById('productTableBody');
            var newRow = tableBody.insertRow();
            var cellIdProduk = newRow.insertCell(0);
            var cellNamaProduk = newRow.insertCell(1);
            var cellHarga = newRow.insertCell(2);
            var cellQty = newRow.insertCell(3);
            var cellSubtotal = newRow.insertCell(4);
            var cellActions = newRow.insertCell(5);

            cellIdProduk.innerText = idProduk;
            cellNamaProduk.innerText = namaProduk;
            cellHarga.innerText = formatRupiah(hargaProduk);
            cellQty.innerText = quantity;
            cellSubtotal.innerText = formatRupiah(subtotal);

            // Tambahkan tombol hapus untuk setiap baris
            var deleteButton = document.createElement('button');
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.innerText = 'Hapus';
            deleteButton.onclick = function () {
                tableBody.deleteRow(newRow.rowIndex);
                totalSubtotal();
            };
            cellActions.appendChild(deleteButton);

            // Hitung ulang total subtotal
            totalSubtotal();

            // Reset form setelah ditambahkan
            resetForm();
        }

        function totalSubtotal() {
            var total = 0;
            var tableBody = document.getElementById('productTableBody');
            for (var i = 0; i < tableBody.rows.length; i++) {
                var subtotal = parseFloat(tableBody.rows[i].cells[4].innerText.replace(/[^\d]/g, ''));
                total += subtotal;
            }
            document.getElementById('totalSubtotal').innerText = formatRupiah(total);
        }

        function removeProduct(button) {
            var row = button.closest('tr');
            row.parentNode.removeChild(row);

            // Hitung ulang total keseluruhan setelah menghapus produk
            calculateTotal();
        }

        function resetForm() {
            // Reset nilai input box
            document.getElementById('idpelanggan').value = '';
            document.getElementById('idkaryawan').value = '';
            document.getElementById('idproduk').value = '';
            document.getElementById('hargaproduk').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('subtotal').value = '';

            // Optional: tambahkan reset lain yang dibutuhkan sesuai kebutuhan
        }

        function updateTotalSubtotal() {
            var totalSubtotal = 0;
            var table = document.getElementById('productTableBody');

            for (var i = 0; i < table.rows.length; i++) {
                var cells = table.rows[i].cells;
                var subtotal = cells[4].innerText.trim().replace(/[^\d]/g, '');
                totalSubtotal += parseInt(subtotal);
            }

            document.getElementById('totalSubtotal').innerText = formatRupiah(totalSubtotal);
        }

        function removeProduct(button) {
            var row = button.closest('tr');
            row.parentNode.removeChild(row);
            updateTotalSubtotal();
        }

        function validateBeforesavee() {
            var namaPelanggan = document.getElementById('idpelanggan').value;
            var namaKaryawan = document.getElementById('idkaryawan').value;
            var tableBody = document.getElementById('productTableBody');

            if (namaPelanggan === '') {
                alert('Nama Pelanggan kosong. Harap diisi.');
                return false;
            }

            if (namaKaryawan === '') {
                alert('Nama Karyawan kosong. Harap diisi.');
                return false;
            }

            if (tableBody.rows.length === 0) {
                alert('List barang kosong. Harap diisi.');
                return false;
            }

            // Semua syarat terpenuhi
            return true;
        }

        function saveeTransaction() {
            var idPelanggan = document.getElementById('idpelanggan').value;
            var idKaryawan = document.getElementById('idkaryawan').value;
            var productTable = document.getElementById('productTableBody');
            var totalSubtotal = document.getElementById('totalSubtotal').innerText.replace(/[^\d]/g, '');
            var date = new Date().toISOString().slice(0, 10);

            if (!idPelanggan) {
                alert('Nama pelanggan kosong harap di isi');
                return;
            }

            if (!idKaryawan) {
                alert('Nama karyawan kosong harap di isi');
                return;
            }

            if (productTable.rows.length === 0) {
                alert('List barang kosong harap di isi');
                return;
            }

            var details = [];
            for (var i = 0; i < productTable.rows.length; i++) {
                var cells = productTable.rows[i].cells;
                var detail = {
                    idproduk: cells[0].innerText,
                    jumlah: cells[3].innerText,
                    harga: cells[2].innerText.replace(/[^\d]/g, '')
                };
                details.push(detail);
            }

            var data = {
                idpelanggan: idPelanggan,
                idkaryawan: idKaryawan,
                tanggal: date,
                total: totalSubtotal,
                details: details
            };

            fetch('savee_detail_transaksi.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    alert('Transaksi berhasil disimpan dengan ID Transaksi: ' + response.idtransaksi);
                    resetForm(); // Kosongkan form setelah penyimpanan berhasil
                } else {
                    alert('Gagal menyimpan transaksi: ' + response.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan dalam menyimpan transaksi.');
            });
        }

        // Skrip JavaScript untuk menangani form dan validasi
        $(document).ready(function() {
            $('#simpanTransaksi').click(function() {
                // Validasi form
                if ($('#namapelanggan').val() === '') {
                    alert('Nama pelanggan kosong harap di isi.');
                    return;
                }
                if ($('#idkaryawan').val() === '') {
                    alert('Nama karyawan kosong harap di isi.');
                    return;
                }
                if ($('#listBarang tbody').children().length === 0) {
                    alert('List barang kosong harap di isi.');
                    return;
                }

                // Mengirim data form ke server
                var formData = $('#formTransaksi').serialize();
                $.post('savee_transaksi.php', formData, function(response) {
                    if (response.success) {
                        alert('Transaksi berhasil disimpan! ID Transaksi: ' + response.idtransaksi);
                        $('#formTransaksi')[0].reset(); // Kosongkan form setelah penyimpanan berhasil
                        $('#listBarang tbody').empty(); // Kosongkan tabel list barang
                    } else {
                        alert('Gagal menyimpan transaksi: ' + response.message);
                    }
                }, 'json');
            });
        });
        
        
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return 'Rp.' + number_string;
        }

        function printNota() {
            var title = 'TB PILAR MAS';
            var alamat = 'Tegalrejo, Dradah Blumbang, Kec. Kedungpring';
            var kasir = '<?php echo $_SESSION["username"]; ?>'; // Ubah untuk memuat nama kasir
            var tanggal = '<?php echo date("d-m-Y"); ?>'; // Tanggal saat ini

            var namaPelanggan = document.getElementById('idpelanggan').selectedOptions[0].innerText.trim();

            var table = document.getElementById('productTableBody');
            var notaContent = '------------------------------------------------------\n';
            notaContent += '                    ' + title + '\n';
            notaContent += '    ' + alamat + '\n';
            notaContent += '\n';
            notaContent += ' ';
            notaContent += '  KASIR: ' + kasir + '     Tanggal: ' + tanggal + '\n';
            notaContent += '   Pelanggan: ' + namaPelanggan + '\n';
            notaContent += '-------------------------------------------------------\n';
            notaContent += ' QTY   PRODUK                HARGA            SUBTOTAL\n';
            notaContent += '-------------------------------------------------------\n';

            for (var i = 0; i < table.rows.length; i++) {
                var cells = table.rows[i].cells;
                var qty = cells[3].innerText.trim();
                var produk = cells[1].innerText.trim();
                var harga = cells[2].innerText.trim();
                var subtotal = cells[4].innerText.trim();
                notaContent += '  ' + qty + '   ' + produk + '   ' + harga + '   ' + subtotal + '\n';
            }

            var totalBelanja = '     Total Belanja: ' + document.getElementById('totalSubtotal').innerText.trim() + '\n';
            notaContent += '------------------------------------------------------\n';
            notaContent += totalBelanja;
            notaContent += '------------------------------------------------------\n';
            notaContent += '     * Terima Kasih Telah Berbelanja Di Toko Kami *\n';

            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<pre>' + notaContent + '</pre>');
            printWindow.document.close();

            printWindow.print();
        }

    </script>
</body>

</html>