<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'mahasiswa') {
  header('Location: login.php');
  exit();
}
include '../config/koneksi.php';

$success = '';
$error = '';

$query = "SELECT * FROM mahasiswa WHERE nim = '{$_SESSION['user']}'";
$mhs = mysqli_fetch_assoc(mysqli_query($conn, $query));

if (!$mhs) {
  header('Location: dashboard_mahasiswa.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
  $jurusan = mysqli_real_escape_string($conn, trim($_POST['jurusan']));
  $angkatan = mysqli_real_escape_string($conn, trim($_POST['angkatan']));

  if ($nama === '') {
    $error = 'Nama tidak boleh kosong.';
  } else {
    $update = "UPDATE mahasiswa SET nama = '$nama', jurusan = '$jurusan', angkatan = '$angkatan' WHERE nim = '{$_SESSION['user']}'";
    if (mysqli_query($conn, $update)) {
      $success = 'Profil berhasil diperbarui.';
      $mhs['nama'] = $nama;
      $mhs['jurusan'] = $jurusan;
      $mhs['angkatan'] = $angkatan;
    } else {
      $error = 'Terjadi kesalahan saat menyimpan profil.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Profil - SIAKAD</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <div class="app-shell">
    <div class="sidebar">
      <div class="brand">
        <h2>Siakad</h2>
        <p>Sistem Informasi Akademik</p>
      </div>
      <button id="sidebar-toggle-btn" class="sidebar-toggle" aria-expanded="true">☰</button>
      <ul>
        <li><a href="dashboard_mahasiswa.php">Dashboard</a></li>
        <li><a href="dashboard_mahasiswa.php#section-schedule">Jadwal Kuliah</a></li>
        <li><a href="dashboard_mahasiswa.php#section-grades">Nilai</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="sidebar-footer">
        <strong>Siakad</strong> • Perbarui data pribadimu kapan saja.
      </div>
    </div>
    <div class="main-content" id="main-content">
      <div class="page-header">
        <div class="page-title">
          <h1>Edit Profil</h1>
          <p>Perbarui informasi dasar akun mahasiswa kamu.</p>
        </div>
      </div>

      <section class="report-panel">
        <?php if ($success) { ?>
          <div class="card" style="background: #ecfdf5; color: #166534;">
            <?php echo $success; ?>
          </div>
        <?php } ?>
        <?php if ($error) { ?>
          <div class="card" style="background: #fee2e2; color: #991b1b;">
            <?php echo $error; ?>
          </div>
        <?php } ?>

        <form action="" method="post" style="display: grid; gap: 18px;">
          <label>
            <span>Nama Lengkap</span>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($mhs['nama']); ?>" required>
          </label>
          <label>
            <span>Jurusan</span>
            <input type="text" name="jurusan" value="<?php echo htmlspecialchars($mhs['jurusan']); ?>">
          </label>
          <label>
            <span>Angkatan</span>
            <input type="text" name="angkatan" value="<?php echo htmlspecialchars($mhs['angkatan']); ?>">
          </label>
          <label>
            <span>NIM</span>
            <input type="text" value="<?php echo htmlspecialchars($mhs['nim']); ?>" disabled>
          </label>
          <div class="profile-actions">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a href="dashboard_mahasiswa.php" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </section>
    </div>
  </div>
  <script src="../assets/script.js"></script>
</body>

</html>