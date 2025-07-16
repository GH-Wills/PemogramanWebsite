<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE user_id = $id_user ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Status Pesanan</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <h1>ElectroTech Batam</h1>
        <div class="container">
            <h2>Status Pesanan Anda</h2>
            <div class="navbar">
                <a href="index.php">Kembali ke Produk</a>
                <a href="logout.php">Logout</a>
            </div>
            <div class="text">
            <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
                <h3>Pesanan #<?= $p['id'] ?> - <?= $p['tanggal'] ?></h3>
                <p>Metode Pembayaran: <?= $p['metode_pembayaran'] ?></p>
                <p><strong>Status:</strong> <?= ucfirst($p['status']) ?></p>

                <?php if ($p['status'] === 'menunggu'): ?>
                    <p>Pesanan Anda menunggu konfirmasi admin.</p>
                <?php elseif ($p['status'] === 'diproses'): ?>
                    <p>Pesanan sedang dikemas dan diproses.</p>
                <?php elseif ($p['status'] === 'dikirim'): ?>
                    <p>Pesanan sedang dalam perjalanan ke alamat Anda.</p>
                <?php elseif ($p['status'] === 'selesai'): ?>
                    <p>Pesanan sudah selesai. Terima kasih!</p>
                <?php endif; ?>
            
                <p>Total: Rp <?= number_format($p['total']) ?></p>
            </div>
                <table border="1" cellpadding="6" cellspacing="0">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>

                    <?php
                    $id_pesanan = $p['id'];
                    $detail = mysqli_query($koneksi, "
                        SELECT dp.jumlah, dp.sub_total, p.nama, p.harga 
                        FROM detail_pemesanan dp
                        JOIN produk p ON dp.id_produk = p.id
                        WHERE dp.id_pemesanan = $id_pesanan
                    ");
                    while ($d = mysqli_fetch_assoc($detail)):
                    ?>
                        <tr>
                            <td><?= $d['nama'] ?></td>
                            <td><?= $d['jumlah'] ?></td>
                            <td>Rp <?= number_format($d['harga']) ?></td>
                            <td>Rp <?= number_format($d['sub_total']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <hr>
            <?php endwhile; ?>
        </div>
    </body>
</html>