<!DOCTYPE HTML>
<html>
    <head>
        <title>Menghitung Nilai MatKul</title>
    </head>
    <body>
        <form action = "" method = "post">
        <div>NIM Mahasiwa</div>
        <input type="text" name="nim" placeholder = "nim">
        <div>Nama Mahasiwa</div>
        <input type="text" name="nama" placeholder = "nama lengkap">
        <div>Jumlah Kehadiran</div>
        <input type="text" name="jk" size = "10">
        <div>Jumlah pertemuan</div>
        <input type="text" name="jp" size = "10">
        <div>Nilai TS</div>
        <input type="text" name="ts" size = "10" placeholder = "0-100">
        <div>Nilai TM</div>
        <input type="text" name="tm" size = "10" placeholder = "0-100">
        <div>Nilai UTS</div>
        <input type="text" name="nilaiuts" size = "10" placeholder = "0-100">
        <div>Nilai UAS</div>
        <input type="text" name="nilaiuas" size = "10" placeholder = "0-100">
        <br><br>
        <input type="submit" value = "Hitung Nilai">
        </form>

        <hr>

<?php
    /*Fungsional*/

function grade($nilai)
{
    if($nilai >= 80) {
        return "A";
    } elseif ($nilai >= 70) {
        return "B";
    } elseif ($nilai >= 60) {
        return "C";
    } elseif ($nilai >= 50) {
        return "D";
    } else {
        return "E";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim  = trim($_POST["nim"]);
    $nama = trim($_POST["nama"]);
    $jk   = (float) trim($_POST["jk"]);
    $jp   = (float) trim($_POST["jp"]);
    $tm   = (float) trim($_POST["tm"]);
    $ts   = (float) trim($_POST["ts"]);
    $uts  = (float) trim($_POST["nilaiuts"]);
    $uas  = (float) trim($_POST["nilaiuas"]);


    if ($jp > 0) {
        $absensi = ($jk / $jp) * 100;
    } else {
        $absensi = 0;
    }

    $nilai = ($absensi * 0.1) + ($ts * 0.15) + ($tm * 0.15) + ($uts * 0.3) + ($uas * 0.3);
    $grade = grade($nilai);

?>

    <h2 align = "center">Data Nilai Mahasiswa</h2>
    <table width = "100%" border = "1" cellspacing = "0" cellpadding = "5">
        <tr bgcolor = "#6945ED">
            <th width = "100">NIM</th>
            <th>Nama Mahasiswa</th>
            <th width = "100">Nilai Absensi</th>
            <th width = "100">Nilai TS</th>
            <th width = "100">Nilai TM</th>
            <th width = "100">Nilai UTS</th>
            <th width = "100">Nilai UAS</th>
            <th width = "100">Nilai Akhir</th>
            <th width = "100">Grade</th>
        </tr>
        <tr bgcolor = "white">
            <td align = "Center"><?php echo htmlspecialchars($nim); ?></td>
            <td><?php echo htmlspecialchars($nama); ?></td> 
            <td align = "Center"><?php echo round($absensi, 2); ?></td>
            <td align = "Center"><?php echo $ts; ?></td>
            <td align = "Center"><?php echo $tm; ?></td>
            <td align = "Center"><?php echo $uts; ?></td>
            <td align = "Center"><?php echo $uas; ?></td>
            <td align = "Center"><?php echo round($nilai, 2); ?></td>
            <td align = "Center"><?php echo $grade; ?></td>
            
        </tr>
    </table>

    <?php } ?>
    </body>
</html>