<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
    <div class="login-box">
      <h2>Form Login</h2>

      <form method="POST" action="proses/login.php">
        <label class="kata">Nama:</label><br>
        <input type="nama" class="in" name="nama" required><br><br>

        <label class="kata">Password:</label><br>
        <input type="password" class="in" name="password" required><br><br>

        <button type="submit" class="tombol">Login</button> 
      </form>
      <p class="text">Belum punya akun? 
        <a class="link-reg" href="register.php">Daftar di sini</a>
      </p>
    </div>
  </body>
</html>