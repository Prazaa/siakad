<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'dosen') {
    header('Location: login.php');
    exit();
}
include '../config/koneksi.php';

// Ambil data dosen
$query = "SELECT * FROM dosen WHERE nip = '{$_SESSION['user']}'";
$dosen = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Ambil mata kuliah yang diajar
$query_mk = "SELECT * FROM mata_kuliah WHERE dosen_id = {$dosen['id']}";
$mk_list = mysqli_query($conn, $query_mk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen - SIAKAD</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="sidebar">
        <h2>Siakad</h2>
        <p>Sistem Informasi Akademik</p>
        <button id="sidebar-toggle-btn" class="sidebar-toggle">Sembunyikan Sidebar</button>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Mata Kuliah</a></li>
            <li><a href="#">Input Nilai</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content" id="main-content">
        <header>
            <div>
                <h1>Dashboard Dosen</h1>
                <p>Selamat datang, <?php echo $dosen['nama']; ?></p>
            </div>
            <button id="open-sidebar-btn" class="sidebar-toggle">Tampilkan Sidebar</button>
        </header>
        <div class="summary">
            <div class="card">
                <h3>NIP</h3>
                <p><?php echo $dosen['nip']; ?></p>
            </div>
            <div class="card">
                <h3>Jurusan</h3>
                <p><?php echo $dosen['jurusan']; ?></p>
            </div>
        </div>
        <div class="table-panel">
            <h3>Mata Kuliah yang Diajar</h3>
            <table>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>SKS</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($mk_list)) { ?>
                    <tr>
                        <td><?php echo $row['kode_mk']; ?></td>
                        <td><?php echo $row['nama_mk']; ?></td>
                        <td><?php echo $row['sks']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script src="../assets/script.js"></script>
</body>

</html>