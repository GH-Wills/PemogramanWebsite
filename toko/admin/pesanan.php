<?php
session_start();
include '../config/koneksi.php';

// Hanya admin yang boleh akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil semua pesanan
$pemesanan = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Semua Pesanan</h2>
        
        <ul>
            <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>

        <?php while ($p = mysqli_fetch_assoc($pemesanan)): ?>
            <h3>Pemesanan #<?= $p['id'] ?> - <?= $p['tanggal'] ?></h3>
            <p>User ID: <?= $p['user_id'] ?></p>
            <p>Total: Rp <?= number_format($p['total']) ?></p>

            <form method="POST" action="../proses/update_status.php">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <label>Status:</label>
                <select name="status">
                    <option <?= $p['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option <?= $p['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option <?= $p['status'] === 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                    <option <?= $p['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
                <button type="submit">Update</button>
            </form>

            <table border="1" cellpadding="6" cellspacing="0">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>

                <?php
                $id_pemesanan = $p['id'];
                $detail = mysqli_query($koneksi, "
                    SELECT dp.jumlah, dp.sub_total, p.nama, p.harga 
                    FROM detail_pemesanan dp
                    JOIN produk p ON dp.id_produk = p.id
                    WHERE dp.id_pemesanan = $id_pemesanan
                ");

                while ($d = mysqli_fetch_assoc($detail)): ?>
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