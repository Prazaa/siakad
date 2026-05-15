<?php
// 1. Tambahkan ini di paling atas untuk melihat error asli
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Cek apakah session user sudah ada
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {

  // Redirect berdasarkan role
  if ($_SESSION['role'] == 'tendik') {
    header('Location: views/dashboard_admin.php');
    exit();
  } elseif ($_SESSION['role'] == 'dosen') {
    header('Location: views/dashboard_dosen.php');
    exit();
  } elseif ($_SESSION['role'] == 'mahasiswa') {
    header('Location: views/dashboard_mahasiswa.php');
    exit();
  }
} else {
  // Jika tidak ada session, lempar ke login
  header('Location: views/login.php');
  exit();
}?>