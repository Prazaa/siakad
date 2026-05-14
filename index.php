<?php
session_start();
if (isset($_SESSION['user'])) {
    // Redirect berdasarkan role
    if ($_SESSION['role'] == 'tendik') {
        header('Location: views/dashboard_admin.php');
    } elseif ($_SESSION['role'] == 'dosen') {
        header('Location: views/dashboard_dosen.php');
    } elseif ($_SESSION['role'] == 'mahasiswa') {
        header('Location: views/dashboard_mahasiswa.php');
    }
    exit();
} else {
    header('Location: views/login.php');
    exit();
}
?>