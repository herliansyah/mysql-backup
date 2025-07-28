# MySQL Database Backup Tool

🚀 **Professional MySQL Database Backup Solution** - Aplikasi web PHP modern dengan antarmuka yang elegan, sistem multibahasa, dan fitur backup database MySQL yang lengkap.

## ✨ Fitur Utama

### 🔗 **Database Management**
- ✅ **Koneksi Database Fleksibel** - Support MySQL/MariaDB dengan konfigurasi host, port, username, password
- ✅ **Test Koneksi Real-time** - Validasi koneksi database sebelum melanjutkan proses
- ✅ **Auto-detection Objects** - Deteksi otomatis semua objek database yang tersedia
- ✅ **Multi-database Support** - Dapat bekerja dengan berbagai database MySQL

### 📊 **Object Selection**
- ✅ **Tabel Database** - Pilih tabel spesifik atau semua tabel sekaligus
- ✅ **Views Management** - Backup views dengan struktur dan definisi lengkap
- ✅ **Triggers Support** - Include triggers dalam backup dengan dependencies
- ✅ **Stored Procedures** - Backup stored procedures dan functions
- ✅ **Selective Backup** - Kontrol granular untuk setiap jenis objek

### ⚙️ **Advanced Backup Options**
- ✅ **Struktur Database** - Backup CREATE statements untuk semua objek
- ✅ **Data Export** - Export data dengan INSERT statements yang optimized
- ✅ **Hybrid Backup** - Kombinasi struktur dan data sesuai kebutuhan
- ✅ **Row Limiting** - Batasi jumlah rows per tabel untuk testing/development
- ✅ **Compression Support** - Kompresi file backup ke format ZIP
- ✅ **Custom Filename** - Generate filename dengan timestamp otomatis

### 🎨 **Modern User Interface**
- ✅ **Step-by-Step Wizard** - Interface wizard yang intuitif dan mudah digunakan
- ✅ **Glassmorphism Design** - Design modern dengan efek glass dan blur
- ✅ **Responsive Layout** - Optimal di desktop, tablet, dan mobile devices
- ✅ **Interactive Progress** - Visual progress indicator dengan animasi smooth
- ✅ **Hover Effects** - Subtle hover effects tanpa animasi yang mengganggu
- ✅ **Dark/Light Themes** - Gradient background yang menarik dan professional

### 🌍 **Multi-language Support**
- ✅ **English Interface** - Complete English translation
- ✅ **Indonesian Interface** - Antarmuka Bahasa Indonesia lengkap
- ✅ **Language Switcher** - Dropdown selector dengan flag icons
- ✅ **Persistent Settings** - Menyimpan pilihan bahasa di localStorage
- ✅ **Real-time Switching** - Ganti bahasa tanpa reload halaman
- ✅ **Extensible System** - Mudah menambah bahasa baru

### 🔒 **Security & Performance**
- ✅ **SQL Injection Protection** - Menggunakan PDO prepared statements
- ✅ **Input Validation** - Validasi komprehensif untuk semua input
- ✅ **Error Handling** - Error handling yang robust dan user-friendly
- ✅ **Memory Management** - Optimized untuk database berukuran besar
- ✅ **Timeout Protection** - Auto-timeout untuk mencegah hanging
- ✅ **File Security** - Protected download directory dengan .htaccess

## 📁 Struktur Aplikasi

```
mysql-backup-tool/
├── 📄 index.php                    # Main application interface
├── 📄 install.php                  # Installation wizard
├── 📄 download.php                 # Secure file download handler
├── 📁 assets/
│   ├── 📁 css/
│   │   └── 🎨 style.css            # Modern CSS with glassmorphism effects
│   └── 📁 js/
│       ├── 🌍 languages.js         # Multi-language system
│       └── ⚡ script.js            # Interactive UI and AJAX handlers
├── 📁 api/
│   ├── 🔌 test-connection.php      # Database connection testing
│   ├── 📊 get-objects.php          # Database objects retrieval
│   └── 💾 generate-backup.php      # Backup generation engine
├── 📁 classes/
│   └── 🏗️ BackupGenerator.php      # Core backup generation class
├── 📁 config/
│   └── ⚙️ config.php               # Application configuration
├── 📁 downloads/
│   ├── 🔒 .htaccess                # Security protection
│   └── 📦 .gitkeep                 # Keep directory in git
├── 📁 examples/
│   └── 🗃️ sample-database.sql      # Sample database for testing
└── 📖 README.md                    # Comprehensive documentation
```

## 🚀 Instalasi

### Metode 1: Quick Setup
1. **Download/Clone** repository ke web server directory
   ```bash
   git clone https://github.com/username/mysql-backup-tool.git
   cd mysql-backup-tool
   ```

2. **Set Permissions** untuk folder downloads
   ```bash
   chmod 755 downloads/
   chown www-data:www-data downloads/  # Linux/Ubuntu
   ```

3. **Akses Aplikasi** melalui web browser
   ```
   http://localhost/mysql-backup-tool/
   ```

### Metode 2: Guided Installation
1. Akses `install.php` untuk wizard instalasi otomatis
2. Ikuti langkah-langkah yang disediakan
3. Sistem akan melakukan pengecekan requirements otomatis

## 💻 Persyaratan Sistem

### Minimum Requirements
- **PHP**: 7.4+ (Recommended: PHP 8.0+)
- **MySQL**: 5.7+ atau **MariaDB**: 10.2+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+
- **Memory**: 128MB (Recommended: 512MB+)
- **Disk Space**: 100MB free space

### PHP Extensions Required
- ✅ `PDO` - Database abstraction layer
- ✅ `PDO_MySQL` - MySQL driver for PDO
- ✅ `mbstring` - Multi-byte string handling
- ✅ `json` - JSON data handling
- ✅ `zip` - File compression (optional)

### Browser Compatibility
- ✅ **Chrome** 90+
- ✅ **Firefox** 88+
- ✅ **Safari** 14+
- ✅ **Edge** 90+
- ✅ **Mobile browsers** (iOS Safari, Chrome Mobile)

## 📖 Cara Penggunaan

### 🌍 Language Selection
Pilih bahasa interface di dropdown header:
- **🇺🇸 English** - Complete English interface
- **🇮🇩 Bahasa Indonesia** - Antarmuka lengkap dalam Bahasa Indonesia

### Step 1: 🔌 Database Connection
1. **Input Connection Details**:
   - **Host**: Database server address (default: localhost)
   - **Port**: MySQL port (default: 3306)
   - **Username**: Database username
   - **Password**: Database password (optional)
   - **Database**: Target database name

2. **Test Connection**: Klik "Test Connection" untuk validasi
3. **Proceed**: Klik "Next" jika koneksi berhasil

### Step 2: 📊 Select Database Objects
**Object Categories Available**:
- **📋 Tables**: Pilih tabel yang akan di-backup
  - Individual selection atau "Select All"
  - Preview jumlah rows per tabel
- **👁️ Views**: Pilih database views
  - Include view definitions
- **⚡ Triggers**: Pilih database triggers
  - Maintain trigger dependencies
- **⚙️ Procedures**: Pilih stored procedures
- **🔧 Functions**: Pilih user-defined functions

**Selection Tips**:
- Gunakan "Select All" untuk memilih semua objek dalam kategori
- Hover pada objek untuk melihat detail informasi
- Dependencies akan ditangani otomatis

### Step 3: ⚙️ Backup Configuration
**Structure Options**:
- ✅ **Include Structure**: Export CREATE statements
  - Table schemas, indexes, constraints
  - View definitions
  - Trigger definitions

**Data Options**:
- ✅ **Include Data**: Export INSERT statements
  - Full data export
  - Row limiting per table
  - Data type preservation

**Advanced Options**:
- 📦 **Compression**: Compress backup to ZIP format
- 🎯 **Row Limiting**: Set maximum rows per table
- 🔄 **Custom Options**: Per-table configuration

### Step 4: 💾 Generate & Download
1. **Review Summary**: Periksa ringkasan backup configuration
2. **Generate**: Klik "Generate Backup" untuk memulai
3. **Monitor Progress**: Real-time progress indicator
4. **Download**: File backup otomatis tersedia untuk download

## 🎯 Advanced Usage

### Custom Row Limiting
```sql
-- Example: Limit user table to 1000 rows
SELECT * FROM users LIMIT 1000;
```

### Backup Scheduling
Untuk backup otomatis, gunakan cron job:
```bash
# Daily backup at 2 AM
0 2 * * * /usr/bin/php /path/to/backup-tool/api/generate-backup.php
```

### Large Database Handling
Untuk database besar (>1GB):
1. Enable compression
2. Set memory limit di PHP
3. Use row limiting untuk testing
4. Consider splitting backup per table

## 📄 Format Output

### SQL Backup Structure
File backup menggunakan format SQL standar yang kompatibel dengan MySQL/MariaDB:

```sql
-- ========================================
-- MySQL Database Backup Tool
-- Generated on: 2024-01-01 12:00:00
-- Database: production_db
-- Version: 1.0.0
-- Language: English
-- ========================================

-- Configuration Settings
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET AUTOCOMMIT = 0;
START TRANSACTION;

-- ========================================
-- DATABASE STRUCTURE
-- ========================================

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- TABLE DATA
-- ========================================

-- Data for table: users (1000 rows)
INSERT INTO `users` VALUES 
(1,'admin','admin@example.com','2024-01-01 10:00:00'),
(2,'user1','user1@example.com','2024-01-01 10:01:00');

-- ========================================
-- VIEWS
-- ========================================

-- View: active_users
DROP VIEW IF EXISTS `active_users`;
CREATE VIEW `active_users` AS 
SELECT * FROM users WHERE status = 'active';

-- ========================================
-- TRIGGERS
-- ========================================

-- Trigger: users_audit
DROP TRIGGER IF EXISTS `users_audit`;
DELIMITER $$
CREATE TRIGGER `users_audit` 
AFTER UPDATE ON `users` 
FOR EACH ROW BEGIN
  INSERT INTO audit_log VALUES (NEW.id, NOW());
END$$
DELIMITER ;

-- ========================================
-- STORED PROCEDURES
-- ========================================

-- Procedure: get_user_stats
DROP PROCEDURE IF EXISTS `get_user_stats`;
DELIMITER $$
CREATE PROCEDURE `get_user_stats`()
BEGIN
  SELECT COUNT(*) as total_users FROM users;
END$$
DELIMITER ;

-- Restore Settings
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- Backup completed successfully!
-- File size: 2.5 MB
-- Objects: 15 tables, 3 views, 5 triggers, 2 procedures
```

### Compressed Output (ZIP)
Ketika compression enabled:
```
backup_production_db_2024-01-01_12-00-00.zip
├── backup_production_db_2024-01-01_12-00-00.sql
├── backup_info.json
└── structure_only.sql (optional)
```

### Backup Info JSON
```json
{
  "database": "production_db",
  "generated_at": "2024-01-01T12:00:00Z",
  "generator": "MySQL Backup Tool v1.0.0",
  "language": "en",
  "options": {
    "include_structure": true,
    "include_data": true,
    "compression": true,
    "row_limit": 1000
  },
  "objects": {
    "tables": 15,
    "views": 3,
    "triggers": 5,
    "procedures": 2,
    "functions": 1
  },
  "file_size": "2.5 MB",
  "estimated_rows": 50000
}
```

## 🔒 Fitur Keamanan

### Input Security
- ✅ **Input Validation**: Validasi komprehensif untuk semua input user
- ✅ **SQL Injection Prevention**: PDO prepared statements dengan parameter binding
- ✅ **XSS Protection**: HTML encoding untuk output data
- ✅ **CSRF Protection**: Token validation untuk form submissions
- ✅ **File Upload Security**: Validasi file type dan size limits

### Database Security
- ✅ **Connection Encryption**: Support SSL/TLS connections
- ✅ **Credential Protection**: Tidak menyimpan credentials di session
- ✅ **Query Sanitization**: Semua query menggunakan prepared statements
- ✅ **Error Masking**: Database errors tidak exposed ke user
- ✅ **Connection Timeout**: Auto-disconnect untuk mencegah hanging connections

### File Security
- ✅ **Download Protection**: Folder downloads dilindungi .htaccess
- ✅ **Secure File Names**: Generated filename dengan sanitization
- ✅ **Temporary File Cleanup**: Auto-cleanup temporary files
- ✅ **Access Control**: Direct file access prevention
- ✅ **File Size Limits**: Configurable maximum file size

### Application Security
- ✅ **Session Management**: Secure session handling
- ✅ **Error Handling**: Comprehensive error handling tanpa information disclosure
- ✅ **Rate Limiting**: Protection against brute force attacks
- ✅ **Memory Management**: Protection against memory exhaustion
- ✅ **Execution Timeout**: Configurable script execution limits

## 🎨 Kustomisasi

### Theme Customization
Edit CSS variables di `assets/css/style.css`:

```css
:root {
    /* Primary Colors */
    --primary-color: #3b82f6;
    --primary-dark: #1d4ed8;
    --secondary-color: #64748b;
    
    /* Status Colors */
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    
    /* Background & Effects */
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    
    /* Shadows & Effects */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}
```

### Adding New Languages
1. **Edit** `assets/js/languages.js`:
```javascript
const languages = {
    en: { /* English translations */ },
    id: { /* Indonesian translations */ },
    es: { /* Spanish translations - NEW */ }
};
```

2. **Add Flag Icon** dalam language selector
3. **Update Dropdown** dengan option baru

### Custom Backup Logic
Extend `classes/BackupGenerator.php`:

```php
class CustomBackupGenerator extends BackupGenerator {
    public function customBackupMethod() {
        // Your custom backup logic
    }
    
    protected function customDataProcessing($data) {
        // Custom data processing
        return $data;
    }
}
```

### API Extensions
Tambah endpoint baru di folder `api/`:

```php
// api/custom-feature.php
<?php
require_once '../config/config.php';

header('Content-Type: application/json');

try {
    // Your custom API logic
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
```

### UI Components
Tambah komponen baru di `index.php`:

```html
<!-- Custom Step -->
<div class="step-content" id="step-custom">
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-custom"></i> <span data-translate="customTitle">Custom Feature</span></h5>
        </div>
        <div class="card-body">
            <!-- Custom content -->
        </div>
    </div>
</div>
```

## 🔧 Troubleshooting

### Database Connection Issues

**❌ Connection Failed**
```bash
# Check MySQL service
sudo systemctl status mysql
sudo systemctl start mysql

# Test connection manually
mysql -h localhost -u username -p database_name
```

**❌ Access Denied**
```sql
-- Grant necessary privileges
GRANT SELECT, SHOW VIEW, TRIGGER ON database_name.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
```

**❌ Host Not Allowed**
```sql
-- Allow connection from specific host
GRANT SELECT ON database_name.* TO 'username'@'%';
-- Or specific IP
GRANT SELECT ON database_name.* TO 'username'@'192.168.1.100';
```

### File Permission Issues

**❌ Cannot Write to Downloads Folder**
```bash
# Linux/Ubuntu
sudo chmod 755 downloads/
sudo chown www-data:www-data downloads/

# CentOS/RHEL
sudo chmod 755 downloads/
sudo chown apache:apache downloads/

# Check current permissions
ls -la downloads/
```

**❌ .htaccess Not Working**
```apache
# Enable mod_rewrite in Apache
sudo a2enmod rewrite
sudo systemctl restart apache2

# Check .htaccess in downloads folder
cat downloads/.htaccess
```

### Performance Issues

**❌ Memory Limit Exceeded**
```php
// In config/config.php or php.ini
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 600);
ini_set('max_input_time', 600);
```

**❌ Large Database Timeout**
```php
// For very large databases
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 1800); // 30 minutes
set_time_limit(1800);
```

**❌ File Size Limits**
```apache
# Apache configuration
php_value upload_max_filesize 500M
php_value post_max_size 500M
php_value max_execution_time 1800
php_value max_input_time 1800
```

```nginx
# Nginx configuration
client_max_body_size 500M;
proxy_read_timeout 1800;
proxy_connect_timeout 1800;
proxy_send_timeout 1800;
```

### Browser Issues

**❌ JavaScript Errors**
1. Check browser console (F12)
2. Ensure jQuery and Bootstrap are loaded
3. Clear browser cache
4. Disable browser extensions

**❌ Language Not Switching**
1. Check localStorage in browser dev tools
2. Clear localStorage: `localStorage.clear()`
3. Refresh page

**❌ Download Not Working**
1. Check popup blocker settings
2. Ensure downloads folder permissions
3. Check browser download settings

### Common Error Messages

**"Connection timeout"**
- Increase `CONNECTION_TIMEOUT` in config
- Check network connectivity
- Verify MySQL server is responding

**"Memory exhausted"**
- Increase PHP memory limit
- Use row limiting for large tables
- Enable compression

**"File not found"**
- Check file permissions
- Verify downloads folder exists
- Check .htaccess configuration

**"Language not loading"**
- Verify `languages.js` is loaded
- Check browser console for errors
- Clear browser cache

### Debug Mode

Enable debug mode untuk troubleshooting:

```php
// In config/config.php
define('ENABLE_DEBUG', true);
define('LOG_ERRORS', true);
```

Check error logs:
```bash
# Check PHP error log
tail -f /var/log/php_errors.log

# Check Apache error log
tail -f /var/log/apache2/error.log

# Check application error log
tail -f logs/error.log
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