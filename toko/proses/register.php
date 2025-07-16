<?php
include '../config/koneksi.php';

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email sudah digunakan
$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Email sudah digunakan!');
        window.location.href = '../register.php';
    </script>";
    exit;
}

// Simpan ke database
$query = "INSERT INTO users (nama, email, password, role) 
          VALUES ('$nama', '$email', '$password', 'user')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
        alert('Registrasi berhasil! Silakan login.');
        window.location.href = '../login.php';
    </script>";
} else {
    echo "<script>
        alert('Registrasi gagal.');
        window.location.href = '../register.php';
    </script>";
}
?>