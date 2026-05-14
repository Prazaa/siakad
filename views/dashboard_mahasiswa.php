<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}
include '../config/koneksi.php';

// Ambil data mahasiswa
$query = "SELECT * FROM mahasiswa WHERE nim = '{$_SESSION['user']}'";
$mhs = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Ambil mata kuliah yang diambil
$query_mk = "SELECT mk.nama_mk, mk.kode_mk, d.nama as dosen, e.nilai FROM enrollment e 
             JOIN mata_kuliah mk ON e.mata_kuliah_id = mk.id 
             JOIN dosen d ON mk.dosen_id = d.id 
             WHERE e.mahasiswa_id = {$mhs['id']}";
$mk_list = mysqli_query($conn, $query_mk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa - SIAKAD</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>WARUNG SIX 1</h2>
        <p>Sistem Informasi Akademik</p>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Jadwal Kuliah</a></li>
            <li><a href="#">Nilai</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Dashboard Mahasiswa</h1>
            <p>Selamat datang, <?php echo $mhs['nama']; ?></p>
        </header>
        <div class="summary">
            <div class="card">
                <h3>NIM</h3>
                <p><?php echo $mhs['nim']; ?></p>
            </div>
            <div class="card">
                <h3>Jurusan</h3>
                <p><?php echo $mhs['jurusan']; ?></p>
            </div>
            <div class="card">
                <h3>Angkatan</h3>
                <p><?php echo $mhs['angkatan']; ?></p>
            </div>
        </div>
        <div class="table-panel">
            <h3>Mata Kuliah yang Diambil</h3>
            <table>
                <tr><th>Kode MK</th><th>Nama MK</th><th>Dosen</th><th>Nilai</th></tr>
                <?php while ($row = mysqli_fetch_assoc($mk_list)) { ?>
                    <tr><td><?php echo $row['kode_mk']; ?></td><td><?php echo $row['nama_mk']; ?></td><td><?php echo $row['dosen']; ?></td><td><?php echo $row['nilai'] ?: '-'; ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>