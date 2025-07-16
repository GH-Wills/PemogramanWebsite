<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// Jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metode'])) {
    $metode = $_POST['metode'];
    $total = 0;

    // Ambil keranjang
    $keranjang = mysqli_query($koneksi, "
        SELECT k.*, p.harga 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id 
        WHERE k.id_user = $id_user
    ");

    $items = [];
    while ($row = mysqli_fetch_assoc($keranjang)) {
        $sub_total = $row['harga'] * $row['jumlah'];
        $total += $sub_total;
        $items[] = [
            'id_produk' => $row['id_produk'],
            'jumlah' => $row['jumlah'],
            'sub_total' => $sub_total
        ];
    }

    // Simpan ke tabel pesanan
    mysqli_query($koneksi, "INSERT INTO pesanan (user_id, metode_pembayaran, total, status)
                            VALUES ($id_user, '$metode', $total, 'menunggu')");
    $id_pesanan = mysqli_insert_id($koneksi);

    // Simpan detail
    foreach ($items as $item) {
        mysqli_query($koneksi, "INSERT INTO detail_pemesanan (id_pemesanan, id_produk, jumlah, sub_total)
                                VALUES ($id_pesanan, '{$item['id_produk']}', {$item['jumlah']}, {$item['sub_total']})");
    }

    // Hapus keranjang
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_user = $id_user");

    echo "<script>
        alert('Pesanan berhasil! Silakan lihat status pesanan Anda.');
        window.location.href = 'status_pesanan.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <h1>ElectroTech Batam</h1>
    <div class="container">
        <h2>Checkout - Metode Pembayaran</h2>

        <form method="POST">
            <label>Pilih Metode Pembayaran:</label><br>
            <input type="radio" name="metode" value="COD" checked> COD (Bayar di tempat)<br>
            <input type="radio" name="metode" value="QRIS"> QRIS / E-Wallet<br><br>
            <button type="submit">Konfirmasi Checkout</button>
        </form>
    </div>
</body>
</html>
