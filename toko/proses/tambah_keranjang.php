<?php
session_start();
include '../config/koneksi.php';

// Pastikan user login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

// Ambil data dari form
$id_user   = $_SESSION['user_id'];
$id_produk = $_POST['id_produk'];
$jumlah    = $_POST['jumlah'];

// Cek apakah produk sudah ada di keranjang
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user=$id_user AND id_produk='$id_produk'");
if (mysqli_num_rows($cek) > 0) {
    // Kalau sudah ada → update jumlah
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah = jumlah + $jumlah 
                            WHERE id_user=$id_user AND id_produk='$id_produk'");
} else {
    // Kalau belum ada → insert baru
    mysqli_query($koneksi, "INSERT INTO keranjang (id_user, id_produk, jumlah) 
                            VALUES ($id_user, '$id_produk', $jumlah)");
}

// Kembali ke halaman utama
header("Location: ../index.php");
?>