<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'tendik') {
  header('Location: login.php');
  exit();
}
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nip = mysqli_real_escape_string($conn, $_POST['nip']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);

  $sql = "INSERT INTO dosen (nip, nama, jurusan) VALUES ('$nip', '$nama', '$jurusan')";
  if (mysqli_query($conn, $sql)) {
    $hash = password_hash('password', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$nip', '$hash', 'dosen')");
    header('Location: dashboard_admin.php');
    exit();
  } else {
    $error = 'Gagal menambahkan dosen: ' . mysqli_error($conn);
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Tambah Dosen - SIAKAD</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <div class="login-background">
    <div class="login-card">
      <h2>Tambah Dosen</h2>
      <?php if (isset($error)) echo "<p class='login-error'>$error</p>"; ?>
      <form method="POST">
        <input name="nip" placeholder="NIP" required>
        <input name="nama" placeholder="Nama" required>
        <input name="jurusan" placeholder="Jurusan" required>
        <button type="submit">Simpan</button>
      </form>
      <p class="login-footer"><a href="dashboard_admin.php">Kembali ke Dashboard</a></p>
    </div>
  </div>
</body>

</html>