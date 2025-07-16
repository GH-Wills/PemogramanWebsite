<?php
  session_start();
  include 'config/koneksi.php';

  // Pastikan hanya user yang bisa akses
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
      header("Location: login.php");
      exit;
  }

  $id_user = $_SESSION['user_id'];

  // Ambil isi keranjang user
  $query = "SELECT k.id, p.nama, p.harga, p.gambar, k.jumlah, (p.harga * k.jumlah) AS total
            FROM keranjang k
            JOIN produk p ON k.id_produk = p.id
            WHERE k.id_user = $id_user";
  $result = mysqli_query($koneksi, $query);
  $jumlah_produk = mysqli_num_rows($result);

  // Hitung total semua item
  $total_belanja = 0;
  ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <h1>ElectroTech Batam</h1>
    <div class="container">
      <h2>Keranjang</h2>
      <div class="navbar">
        <a href="index.php">Kembali ke Produk</a>
        <a href="logout.php">Logout</a>
      </div>

      <table border="1" cellpadding="8" cellspacing="0">
        <tr>
          <th>Gambar</th>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Aksi</th>
          <th>Total</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td>
              <?php if (!empty($row['gambar'])): ?>
                <img src="img/<?= $row['gambar'] ?>" width="80">
              <?php else: ?>
                (Tidak ada gambar)
              <?php endif; ?>
            </td>
            <td><?= $row['nama'] ?></td>
            <td>Rp <?= number_format($row['harga']) ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td>
              <form method="POST" action="proses/hapus_keranjang.php" class="table-form" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                <input type="hidden" name="id_keranjang" value="<?= $row['id'] ?>">
                <button type="submit">Hapus</button>
              </form>
            </td>
            <td>Rp <?= number_format($row['total']) ?></td>
          </tr>
          <?php $total_belanja += $row['total']; ?>
        <?php endwhile; ?>
          
        <tr>
          <td colspan="5"><strong>Total Belanja</strong></td>
          <td><strong>Rp <?= number_format($total_belanja) ?></strong></td>
        </tr>
      </table>

      <br>
      <?php if ($jumlah_produk > 0): ?>
        <form method="POST" action="checkout.php">
          <button type="submit">Lanjut ke Checkout</button>
        </form>
      <?php else: ?>
      <p><strong>Keranjang Anda kosong.</strong></p>
      <?php endif; ?>
    </div>    
  </body>
</html>
