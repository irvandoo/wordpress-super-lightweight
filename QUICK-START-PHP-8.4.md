# Quick Start: Upgrade Laragon ke PHP 8.4

## 🚀 Cara Tercepat (Recommended)

### Opsi 1: Manual Download & Install (5 menit)

1. **Download PHP 8.4:**
   - Buka: https://windows.php.net/download/
   - Download: **PHP 8.4.x Thread Safe (TS) x64 VS16**
   - File: `php-8.4.x-Win32-vs16-x64.zip`

2. **Extract & Install:**
   ```
   - Extract ZIP file
   - Rename folder menjadi: php-8.4.x-Win32-vs16-x64
   - Copy ke: D:\Installed\laragon\bin\php\
   ```

3. **Switch PHP di Laragon:**
   ```
   - Buka Laragon
   - Klik kanan icon di system tray
   - PHP → Version → php-8.4.x
   - Laragon restart otomatis
   ```

4. **Verifikasi:**
   ```
   - Buka: http://localhost/
   - Klik: phpinfo
   - Cek: PHP Version = 8.4.x
   ```

5. **Hapus PHP 8.3 (Opsional):**
   ```
   - Stop Laragon
   - Hapus folder: D:\Installed\laragon\bin\php\php-8.3.30-Win32-vs16-x64
   - Start Laragon
   ```

### Opsi 2: Gunakan PowerShell Script (Otomatis)

1. **Jalankan Script:**
   ```powershell
   .\upgrade-php-laragon.ps1
   ```

2. **Ikuti Instruksi:**
   - Script akan guide step-by-step
   - Download manual saat diminta
   - Script akan install otomatis

## ✅ Verifikasi Setelah Upgrade

### 1. Cek PHP Version
```bash
php -v
```
Expected: `PHP 8.4.x`

### 2. Cek WordPress Theme
```
1. Login WordPress admin
2. Appearance → Themes
3. Cek "Irvandoda Full SEO Lightweight"
4. Seharusnya tidak ada warning lagi
```

### 3. Test Theme Activation
```
1. Activate theme
2. Visit site
3. Cek tidak ada error
```

## 🔧 Konfigurasi PHP 8.4 untuk WordPress

Edit `php.ini` (Menu Laragon → PHP → php.ini):

```ini
memory_limit = 256M
max_execution_time = 300
post_max_size = 128M
upload_max_filesize = 128M

; Enable extensions
extension=curl
extension=gd
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip
extension=fileinfo

; OPcache untuk performance
opcache.enable=1
opcache.jit=1255
opcache.jit_buffer_size=128M
```

## 📊 Struktur Folder Setelah Upgrade

**Before:**
```
D:\Installed\laragon\bin\php\
└── php-8.3.30-Win32-vs16-x64\
```

**After:**
```
D:\Installed\laragon\bin\php\
└── php-8.4.x-Win32-vs16-x64\
```

## 🐛 Troubleshooting

**Problem: PHP 8.4 tidak muncul di menu**
- Solution: Pastikan nama folder format: `php-8.4.x-Win32-vs16-x64`
- Restart Laragon

**Problem: Apache tidak start**
- Solution: Cek `D:\Installed\laragon\bin\apache\logs\error.log`
- Pastikan PHP compatible dengan Apache

**Problem: WordPress error**
- Solution: Clear cache, reactivate theme

## 📞 Support

- Email: irvando.d.a@gmail.com
- WhatsApp: +62 857-4747-6308
- Website: https://irvandoda.my.id

---

**Total Time:** ~5-10 menit
**Difficulty:** Easy
**Status:** Ready to Execute
