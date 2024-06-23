<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Code untuk halaman admin
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <p>This is the admin dashboard.</p>
    <a href="../logout.php">Logout</a>
</body>
</html>
