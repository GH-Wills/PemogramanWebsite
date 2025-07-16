<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
// Validasi input
if (isset($_POST['id_keranjang'])) {
    $id_keranjang = (int) $_POST['id_keranjang'];
    $id_user = (int) $_SESSION['user_id'];

    // Eksekusi query hapus
    $query = "DELETE FROM keranjang WHERE id = $id_keranjang AND id_user = $id_user";
    mysqli_query($koneksi, $query);
}

//kembali
header("Location: ../keranjang.php");
exit;
