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
  <div class="app-shell">
    <div class="sidebar">
      <div class="brand">
        <h2>Siakad</h2>
        <p>Sistem Informasi Akademik</p>
      </div>
      <button id="sidebar-close-btn" class="sidebar-close-btn">Sembunyikan Sidebar</button>
      <ul>
        <li><a href="#section-dashboard">Dashboard</a></li>
        <li><a href="#section-schedule">Jadwal Kuliah</a></li>
        <li><a href="#section-grades">Nilai</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="sidebar-footer">
        <strong>Siakad</strong> • Pantau nilai dan jadwal kuliah Anda di satu tempat.
      </div>
    </div>
    <div class="main-content" id="main-content">
      <div class="page-header">
        <div class="page-title">
          <h1>Dashboard Mahasiswa</h1>
          <p>Ringkasan akademik dan daftar mata kuliah.</p>
        </div>
        <div class="topnav">
          <a href="#section-dashboard">Dashboard</a>
          <a href="#section-schedule">Jadwal Kuliah</a>
          <a href="#section-grades">Nilai</a>
        </div>
        <div class="main-actions">
          <button class="secondary" type="button" onclick="location.reload()">Refresh</button>
          <button id="sidebar-open-btn" class="sidebar-open-btn">Tampilkan Sidebar</button>
        </div>
      </div>
      <section id="section-dashboard" class="summary">
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
      </section>
      <section id="section-schedule" class="table-panel">
        <h3>Jadwal Kuliah</h3>
        <p>Belum ada jadwal terdaftar. Silakan hubungi admin untuk input jadwal.</p>
      </section>
      <section id="section-grades" class="table-panel">
        <h3>Nilai</h3>
        <table>
          <tr>
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th>Dosen</th>
            <th>Nilai</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($mk_list)) { ?>
          <tr>
            <td><?php echo $row['kode_mk']; ?></td>
            <td><?php echo $row['nama_mk']; ?></td>
            <td><?php echo $row['dosen']; ?></td>
            <td><?php echo $row['nilai'] ?: '-'; ?></td>
          </tr>
          <?php } ?>
        </table>
      </section>
    </div>
  </div>
  <script src="../assets/script.js"></script>
</body>

</html>