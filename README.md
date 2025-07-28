# MySQL Database Backup Tool

Aplikasi web PHP untuk backup database MySQL dengan UI/UX modern dan fitur kustomisasi lengkap.

## Fitur Utama

- ✅ **Koneksi Database Fleksibel** - Input host, port, username, password, dan database
- ✅ **Test Koneksi** - Validasi koneksi sebelum melanjutkan
- ✅ **Pilihan Objek Database** - Pilih tabel, views, triggers, procedures, dan functions
- ✅ **Opsi Backup Fleksibel** - Pilih struktur saja, data saja, atau keduanya
- ✅ **Kontrol Data Tabel** - Backup semua data atau batasi jumlah rows per tabel
- ✅ **UI/UX Modern** - Interface yang menarik dengan Bootstrap 5 dan animasi CSS
- ✅ **Progress Tracking** - Monitor progress backup secara real-time
- ✅ **Download Otomatis** - File backup langsung dapat didownload

## Struktur Aplikasi

```
mysql-backup-tool/
├── index.php                 # Halaman utama aplikasi
├── assets/
│   ├── css/
│   │   └── style.css         # Styling modern dengan CSS custom
│   └── js/
│       └── script.js         # JavaScript untuk interaksi UI
├── api/
│   ├── test-connection.php   # API untuk test koneksi database
│   ├── get-objects.php       # API untuk mengambil objek database
│   └── generate-backup.php   # API untuk generate backup
├── classes/
│   └── BackupGenerator.php   # Class utama untuk generate backup
├── downloads/
│   └── .htaccess            # Konfigurasi keamanan untuk folder download
└── README.md                # Dokumentasi aplikasi
```

## Instalasi

1. **Clone atau download** aplikasi ke web server Anda
2. **Pastikan PHP 7.4+** dan ekstensi PDO MySQL terinstall
3. **Set permission** folder `downloads/` agar dapat ditulis (chmod 755)
4. **Akses** aplikasi melalui web browser

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- Ekstensi PHP: PDO, PDO_MySQL
- MySQL 5.7 atau MariaDB 10.2+
- Web server (Apache/Nginx)

## Cara Penggunaan

### 1. Koneksi Database
- Masukkan detail koneksi database MySQL
- Klik "Test Koneksi" untuk memvalidasi
- Klik "Lanjut" jika koneksi berhasil

### 2. Pilih Objek Database
- **Tabel**: Pilih tabel yang akan di-backup
- **Views**: Pilih views yang akan di-backup
- **Triggers**: Pilih triggers yang akan di-backup
- **Procedures**: Pilih stored procedures (jika ada)
- **Functions**: Pilih functions (jika ada)
- Gunakan "Pilih Semua" untuk memilih semua objek dalam kategori

### 3. Opsi Backup
- **Sertakan Struktur**: Include CREATE TABLE/VIEW/etc statements
- **Sertakan Data**: Include INSERT statements untuk data
- **Opsi Data Tabel**: 
  - Semua data: Backup seluruh data tabel
  - Batasi jumlah: Tentukan jumlah rows maksimal per tabel

### 4. Generate Backup
- Review ringkasan backup
- Klik "Generate Backup" untuk memulai proses
- Monitor progress backup
- Download file backup setelah selesai

## Format Output

File backup yang dihasilkan berformat SQL standar dengan struktur:

```sql
-- MySQL Database Backup
-- Generated on: 2024-01-01 12:00:00
-- Database: nama_database

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
-- ... konfigurasi lainnya

-- Tables
DROP TABLE IF EXISTS `table_name`;
CREATE TABLE `table_name` (...);
INSERT INTO `table_name` VALUES (...);

-- Views
DROP VIEW IF EXISTS `view_name`;
CREATE VIEW `view_name` AS ...;

-- Triggers
DROP TRIGGER IF EXISTS `trigger_name`;
CREATE TRIGGER `trigger_name` ...;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
```

## Fitur Keamanan

- **Validasi Input**: Semua input divalidasi sebelum diproses
- **Prepared Statements**: Menggunakan PDO prepared statements
- **Error Handling**: Error handling yang komprehensif
- **File Protection**: Folder downloads dilindungi dengan .htaccess
- **SQL Injection Prevention**: Menggunakan parameter binding

## Kustomisasi

### Mengubah Styling
Edit file `assets/css/style.css` untuk mengubah tampilan:

```css
:root {
    --primary-color: #2563eb;    /* Warna utama */
    --secondary-color: #64748b;  /* Warna sekunder */
    --success-color: #059669;    /* Warna sukses */
    /* ... variabel lainnya */
}
```

### Menambah Fitur
1. Tambahkan fungsi di `classes/BackupGenerator.php`
2. Update API endpoints di folder `api/`
3. Tambahkan UI controls di `index.php`
4. Update JavaScript di `assets/js/script.js`

## Troubleshooting

### Error Koneksi Database
- Pastikan credentials database benar
- Cek apakah MySQL server berjalan
- Verifikasi firewall tidak memblokir koneksi
- Pastikan user memiliki privilege yang cukup

### Error Permission
```bash
# Set permission folder downloads
chmod 755 downloads/
chown www-data:www-data downloads/
```

### Error Memory Limit
Untuk database besar, tingkatkan memory limit PHP:
```php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
```

### Error File Size
Untuk backup file besar, sesuaikan konfigurasi web server:
```apache
# Apache .htaccess
php_value upload_max_filesize 100M
php_value post_max_size 100M
```

## Kontribusi

Kontribusi sangat diterima! Silakan:
1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Aplikasi ini menggunakan lisensi MIT. Bebas digunakan untuk keperluan komersial maupun non-komersial.

## Changelog

### v1.0.0 (2024-01-01)
- ✅ Rilis pertama
- ✅ Fitur backup tabel, views, triggers
- ✅ UI/UX modern dengan Bootstrap 5
- ✅ Opsi kustomisasi backup
- ✅ Progress tracking
- ✅ Download otomatis

## Support

Jika mengalami masalah atau memiliki pertanyaan:
1. Cek dokumentasi di README.md
2. Periksa troubleshooting guide
3. Buat issue di repository

---

**Dibuat dengan ❤️ menggunakan PHP, MySQL, Bootstrap 5, dan JavaScript**