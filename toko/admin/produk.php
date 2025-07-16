<?php
session_start();
include '../config/koneksi.php';

// Hanya admin yang boleh akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Tambah produk
if (isset($_POST['tambah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

     // Upload gambar ke folder img/
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = '../img/' . $gambar;
    move_uploaded_file($tmp, $folder);

    mysqli_query($koneksi, "INSERT INTO produk (id, nama, deskripsi, harga, stok, gambar) 
        VALUES ('$id', '$nama', '$deskripsi', $harga, $stok, '$gambar')");
    header("Location: produk.php");
    exit;
}

// Update produk
if (isset($_POST['update'])) {
    $id         = $_POST['id'];
    $nama       = $_POST['nama'];
    $deskripsi  = $_POST['deskripsi'];
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = '../img/' . $gambar;

        // Hapus gambar lama
        $gambar_lama_query = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id='$id'");
        $gambar_lama = mysqli_fetch_assoc($gambar_lama_query)['gambar'];
        if (!empty($gambar_lama) && file_exists('../img/' . $gambar_lama)) {
            unlink('../img/' . $gambar_lama);
        }

        move_uploaded_file($tmp, $folder);

        mysqli_query($koneksi, "UPDATE produk 
            SET nama='$nama', deskripsi='$deskripsi', harga=$harga, stok=$stok, gambar='$gambar' 
            WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE produk 
            SET nama='$nama', deskripsi='$deskripsi', harga=$harga, stok=$stok 
            WHERE id='$id'");
    }

    header("Location: produk.php");
    exit;
}


// Hapus produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$id'");
    header("Location: produk.php");
    exit;
}

// Ambil data produk untuk form edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$id_edit'");
    $edit_data = mysqli_fetch_assoc($result);
}

// Ambil semua produk
$produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h2>Manajemen Produk</h2>
        <ul>
            <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
        
        <h3><?= $edit_data ? 'Edit Produk' : 'Tambah Produk Baru' ?></h3>
        <form method="POST" enctype="multipart/form-data">
            <label>ID Produk (Kode):</label><br>
            <input type="text" name="id" value="<?= $edit_data['id'] ?? '' ?>" <?= $edit_data ? 'readonly' : '' ?> required><br><br>

            <label>Nama Produk:</label><br>
            <input type="text" name="nama" value="<?= $edit_data['nama'] ?? '' ?>" required><br><br>

            <label>Deskripsi:</label><br>
            <textarea name="deskripsi" required><?= $edit_data['deskripsi'] ?? '' ?></textarea><br><br>

            <label>Harga:</label><br>
            <input type="number" name="harga" value="<?= $edit_data['harga'] ?? '' ?>" required><br><br>

            <label>Stok:</label><br>
            <input type="number" name="stok" value="<?= $edit_data['stok'] ?? '' ?>" required><br><br>

            <label>Gambar:</label><br>
            <input type="file" name="gambar" <?= $edit_data ? '' : 'required' ?>><br><br>
            <?php if ($edit_data): ?>
                <button type="submit" name="update">Simpan Perubahan</button>
                <a href="produk.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="tambah">Simpan</button>
            <?php endif; ?>
        </form>


        <h3>Daftar Produk</h3>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
                <th>Gambar</th>
            </tr>

            <?php while ($p = mysqli_fetch_assoc($produk)): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nama'] ?></td>
                    <td>Rp <?= number_format($p['harga']) ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td>
                        <a href="produk.php?edit=<?= $p['id'] ?>">Edit</a> | 
                        <a href="produk.php?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                    </td>
                    <td>
                        <?php if (!empty($p['gambar'])): ?>
                            <a href="../img/<?= $p['gambar'] ?>" target="_blank">
                                <img src="../img/<?= $p['gambar'] ?>" width="80"><br>
                                <small>Lihat Gambar</small>
                            </a>
                        <?php else: ?>
                            (Belum ada)
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
