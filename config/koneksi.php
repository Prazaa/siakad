<?php
$host   = getenv('MYSQLHOST');
$user   = getenv('MYSQLUSER');
$pass   = getenv('MYSQLPASSWORD');
$dbname = getenv('MYSQLDATABASE');
$port   = getenv('MYSQLPORT');

// Gunakan parameter ke-5 untuk port karena Railway internal pakai 3306
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
