<?php
session_start();
include '../config/koneksi.php';

// Ambil data dari form
$nama = $_POST['nama'];
$password = $_POST['password'];

// Cek user di database
$query = "SELECT * FROM users WHERE nama = '$nama' AND password = '$password'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

if ($user) {
    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // Redirect sesuai role
    if ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit;
} else {
    // Jika login gagal
    echo "<script>
        alert('Email atau password salah!');
        window.location.href = '../login.php';
    </script>";
}
?>