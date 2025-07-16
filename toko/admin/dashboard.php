<?php
session_start();

// Cek apakah yang login adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h2>Selamat datang, <?= $_SESSION['nama'] ?> (Admin)</h2>
        <ul>
            <li><a href="produk.php">Kelola Produk</a></li>
            <li><a href="pesanan.php">Kelola Pesanan</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>