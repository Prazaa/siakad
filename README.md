# SIAKAD - Sistem Informasi Akademik

Web aplikasi SIAKAD dengan login berdasarkan NIM/NIP dan klasifikasi mahasiswa, dosen, tendik.

## Setup Lokal
1. Import `database/schema.sql` ke MySQL (via phpMyAdmin).
2. Jalankan XAMPP, akses `http://localhost/siakad`.

## Deploy ke Railway
1. Push kode ke GitHub.
2. Buat project di Railway, connect ke repo GitHub.
3. Tambah database MySQL di Railway.
4. Set environment variables di Railway. Aplikasi sudah mendukung kedua format:
   - DB_HOST / MYSQLHOST
   - DB_USER / MYSQLUSER
   - DB_PASS / MYSQLPASSWORD
   - DB_NAME / MYSQLDATABASE
   - MYSQL_URL atau MYSQL_PUBLIC_URL juga didukung
5. Railway akan deploy otomatis.

## Fitur
- Login dengan NIM/NIP
- Dashboard berdasarkan role
- Relasi mahasiswa-mata kuliah-dosen