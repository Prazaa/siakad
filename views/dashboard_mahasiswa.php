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
            <button id="sidebar-toggle-btn" class="sidebar-toggle" aria-expanded="true">☰</button>
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
                    <h1>Selamat Malam, <?php echo explode(' ', $mhs['nama'])[0]; ?>!</h1>
                    <p>Semoga harimu menyenangkan. Berikut ringkasan akademikmu.</p>
                </div>
                <div class="main-actions">
                    <button class="secondary" type="button" onclick="location.reload()">Refresh</button>
                </div>
            </div>
            <?php
            $stats_query = "SELECT COUNT(*) AS total_mk, COALESCE(SUM(m.sks),0) AS total_sks
                      FROM enrollment e
                      JOIN mata_kuliah m ON e.mata_kuliah_id = m.id
                      WHERE e.mahasiswa_id = {$mhs['id']}";
            $stats = mysqli_fetch_assoc(mysqli_query($conn, $stats_query));
            $photo_url = isset($mhs['photo']) && !empty($mhs['photo']) && file_exists(__DIR__ . '/../uploads/' . $mhs['photo'])
                ? '../uploads/' . $mhs['photo']
                : null;
            ?>

            <section id="section-dashboard" class="student-dashboard">
                <div class="student-panel">
                    <div class="profile-hero">
                        <div class="profile-avatar">
                            <?php if ($photo_url) { ?>
                                <img src="<?php echo $photo_url; ?>" alt="Foto Profil">
                            <?php } else { ?>
                                <span><?php echo strtoupper(substr($mhs['nama'], 0, 1)); ?></span>
                            <?php } ?>
                        </div>
                        <div class="profile-meta">
                            <h2><?php echo $mhs['nama']; ?></h2>
                            <p class="muted"><?php echo $mhs['nim']; ?></p>
                            <span class="status-pill">Aktif</span>
                        </div>
                    </div>
                    <div class="student-details">
                        <dl>
                            <dt>Program Studi</dt>
                            <dd><?php echo $mhs['jurusan']; ?></dd>
                            <dt>Angkatan</dt>
                            <dd><?php echo $mhs['angkatan']; ?></dd>
                            <dt>Dosen Wali</dt>
                            <dd>Belum ditentukan</dd>
                            <dt>Email</dt>
                            <dd><?php echo strtolower($mhs['nim']); ?>@siakad.local</dd>
                        </dl>
                    </div>
                    <div class="profile-actions">
                        <a href="profile_mahasiswa.php" class="btn btn-primary">Edit Profil</a>
                        <a href="#section-grades" class="btn btn-secondary">Lihat Nilai</a>
                    </div>
                </div>

                <div class="student-overview">
                    <div class="stats-grid">
                        <div class="stats-card">
                            <h3>IPK</h3>
                            <p>-</p>
                            <small>Data belum tersedia</small>
                        </div>
                        <div class="stats-card">
                            <h3>Matakuliah</h3>
                            <p><?php echo $stats['total_mk']; ?></p>
                            <small>Jumlah matakuliah aktif</small>
                        </div>
                        <div class="stats-card">
                            <h3>Total SKS</h3>
                            <p><?php echo $stats['total_sks']; ?></p>
                            <small>SKS terdaftar</small>
                        </div>
                    </div>
                    <div class="quick-actions">
                        <a href="#section-schedule" class="quick-card">
                            <span>Jadwal Kuliah</span>
                        </a>
                        <a href="#section-grades" class="quick-card">
                            <span>Nilai</span>
                        </a>
                        <a href="profile_mahasiswa.php" class="quick-card">
                            <span>Profil</span>
                        </a>
                    </div>
                </div>
            </section>

            <section id="section-schedule" class="report-panel">
                <div class="section-title">
                    <h2>Jadwal Kuliah</h2>
                    <a href="#section-grades">Lihat Nilai</a>
                </div>
                <p>Belum ada jadwal terdaftar. Silakan hubungi admin untuk input jadwal.</p>
            </section>

            <section id="section-grades" class="report-panel">
                <div class="section-title">
                    <h2>Nilai</h2>
                    <a href="profile_mahasiswa.php">Edit Profil</a>
                </div>
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