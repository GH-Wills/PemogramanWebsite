<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registrasi</title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div class="login-box">
            <h2>Form Registrasi</h2>

        <form method="POST" action="proses/register.php">
            <label class="kata">Nama:</label><br>
            <input type="text" class="in" name="nama" required><br><br>

            <label class="kata">Email:</label><br>
            <input type="email" class="in" name="email" required><br><br>

            <label class="kata">Password:</label><br>
            <input type="password" class="in" name="password" required><br><br>

            <button type="submit" class="tombol">Daftar</button>
        </form>

          <p class="text">Sudah punya akun? 
            <a class="link-reg" href="login.php">Login di sini</a>
          </p>
        </div>
    </body>
</html>