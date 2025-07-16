<?php
session_start();
include 'config/koneksi.php';
$produk = mysqli_query($koneksi, "SELECT*FROM produk");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Beranda</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <h1>ElectroTech Batam</h1>
        <div class="container">
            <h2>Selamat datang di ElectroTech<?= isset($_SESSION['nama']) ? ', ' . $_SESSION['nama'] : '' ?>!</h2>

            <div class="navbar">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="keranjang.php">Keranjang</a>
                    <a href="status_pesanan.php">Status Pesanan</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>

            <h3>Produk Tersedia:</h3>
            <ul>
                <?php while ($p = mysqli_fetch_assoc($produk)): ?>
                    <li>
                        <?php if (!empty($p['gambar'])): ?>
                            <a href="img/<?= $p['gambar'] ?>" target="_blank">
                                <img src="img/<?= $p['gambar'] ?>" width="120" style="border:1px solid #ccc; padding:4px;"><br>
                            </a>
                        <?php endif; ?>

                        <strong><?= $p['nama'] ?></strong><br>
                        <?= $p['deskripsi'] ?><br>
                        Rp <?= number_format($p['harga']) ?><br>
                        Stok: <?= $p['stok'] ?><br>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
                            <?php if ($p['stok'] > 0): ?>
                                <form method="POST" action="proses/tambah_keranjang.php">
                                    <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                                    <input type="number" name="jumlah" value="1" min="1" max="<?= $p['stok'] ?>">
                                    <button type="submit">Tambah ke Keranjang</button>
                                </form>
                            <?php else: ?>
                                <p><em>Stok habis</em></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p><a href="login.php">Login untuk membeli</a></p>
                        <?php endif; ?>
                        <hr>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </body>
</html>
