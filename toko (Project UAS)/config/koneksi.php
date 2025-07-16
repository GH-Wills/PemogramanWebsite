<?php
$koneksi = mysqli_connect("localhost", "root", "", "toko");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>