<?php
session_start(); // Panggil session_start() di sini

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_q2';

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

