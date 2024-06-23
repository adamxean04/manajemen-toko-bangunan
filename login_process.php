<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM karyawan WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $hitung = mysqli_num_rows($result);

    if ($hitung > 0) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $_SESSION['log'] = 'logged';
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: user/index.php');
        }
    } else {
        echo 'Username atau password salah';
    }
}
?>