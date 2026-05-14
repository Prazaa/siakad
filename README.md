# SIAKAD - Sistem Informasi Akademik

Web aplikasi SIAKAD dengan login berdasarkan NIM/NIP dan klasifikasi mahasiswa, dosen, tendik.

## Setup Lokal
1. Import `database/schema.sql` ke MySQL (via phpMyAdmin).
2. Jalankan XAMPP, akses `http://localhost/siakad`.

## Deploy ke Railway
1. Push kode ke GitHub.
2. Buat project di Railway, connect ke repo GitHub.
3. Tambah database MySQL di Railway.
4. Set environment variables di Railway:
   - DB_HOST: Railway DB host
   - DB_USER: Railway DB user
   - DB_PASS: Railway DB password
   - DB_NAME: Railway DB name
5. Update `config/koneksi.php` untuk menggunakan env vars.
6. Railway akan deploy otomatis.

## Fitur
- Login dengan NIM/NIP
- Dashboard berdasarkan role
- Relasi mahasiswa-mata kuliah-dosen