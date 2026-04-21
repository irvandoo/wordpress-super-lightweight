# Panduan Upgrade Laragon ke PHP 8.4

## Status Saat Ini
- PHP Version: 8.3.30
- Location: `D:\Installed\laragon\bin\php\php-8.3.30-Win32-vs16-x64`
- Status: Perlu upgrade ke PHP 8.4

## Langkah-Langkah Upgrade

### 1. Download PHP 8.4 untuk Windows

**Link Download:**
https://windows.php.net/download/

**Pilih versi:**
- PHP 8.4.x (latest stable)
- Thread Safe (TS) - untuk Apache/Laragon
- x64 (64-bit)
- VS16 atau VS17 (Visual Studio version)

**File yang didownload:**
`php-8.4.x-Win32-vs16-x64.zip` atau `php-8.4.x-Win32-vs17-x64.zip`

### 2. Extract PHP 8.4 ke Laragon

**Langkah:**
1. Extract file zip yang sudah didownload
2. Rename folder hasil extract menjadi: `php-8.4.x-Win32-vs16-x64` (sesuaikan dengan versi)
3. Copy folder tersebut ke: `D:\Installed\laragon\bin\php\`

**Struktur folder setelah copy:**
```
D:\Installed\laragon\bin\php\
├── php-8.3.30-Win32-vs16-x64\  (versi lama)
└── php-8.4.x-Win32-vs16-x64\   (versi baru)
```

### 3. Switch PHP Version di Laragon

**Cara 1: Via Laragon Menu (Recommended)**
1. Buka Laragon
2. Klik kanan pada Laragon icon di system tray
3. Pilih: **PHP** → **Version** → **php-8.4.x**
4. Laragon akan restart otomatis
5. Verifikasi dengan: Menu → **PHP** → **Quick app** → **phpinfo**

**Cara 2: Manual Edit php.ini**
1. Buka Laragon
2. Menu → **PHP** → **php.ini**
3. Pastikan semua extension yang diperlukan aktif
4. Save dan restart Laragon

### 4. Verifikasi PHP 8.4

**Via Laragon Terminal:**
```bash
php -v
```

**Expected output:**
```
PHP 8.4.x (cli) (built: xxx)
Copyright (c) The PHP Group
Zend Engine v4.4.x, Copyright (c) Zend Technologies
```

**Via Browser:**
1. Buka: http://localhost/
2. Klik **phpinfo**
3. Cek: **PHP Version** harus menunjukkan 8.4.x

### 5. Hapus PHP 8.3.30 (Opsional)

**PERINGATAN:** Backup dulu sebelum menghapus!

**Langkah:**
1. Stop Laragon
2. Backup folder: `D:\Installed\laragon\bin\php\php-8.3.30-Win32-vs16-x64\`
3. Hapus folder tersebut
4. Start Laragon
5. Verifikasi PHP 8.4 masih berfungsi

**Struktur folder setelah hapus:**
```
D:\Installed\laragon\bin\php\
└── php-8.4.x-Win32-vs16-x64\   (hanya versi ini)
```

### 6. Konfigurasi PHP 8.4 untuk WordPress

**Edit php.ini:**
```ini
; Memory & Performance
memory_limit = 256M
max_execution_time = 300
max_input_time = 300
post_max_size = 128M
upload_max_filesize = 128M

; Error Reporting (Production)
display_errors = Off
display_startup_errors = Off
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
log_errors = On
error_log = "D:\Installed\laragon\www\error.log"

; Extensions (Required for WordPress)
extension=curl
extension=gd
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip
extension=fileinfo
extension=intl
extension=exif
extension=sodium

; OPcache (Performance)
zend_extension=opcache
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
opcache.enable_cli=0
opcache.jit=1255
opcache.jit_buffer_size=128M

; Session
session.save_handler = files
session.save_path = "D:\Installed\laragon\tmp"

; Timezone
date.timezone = Asia/Jakarta
```

### 7. Restart Services

**Via Laragon:**
1. Stop All
2. Start All
3. Verifikasi semua service running (Apache, MySQL)

### 8. Test WordPress dengan PHP 8.4

**Langkah:**
1. Buka: http://localhost/active/wordpress%20super%20lightweight/
2. Login ke WordPress admin
3. Pergi ke: **Appearance** → **Themes**
4. Cek theme "Irvandoda Full SEO Lightweight"
5. Seharusnya tidak ada warning lagi tentang PHP version

**Expected Result:**
- ✅ Theme bisa diaktifkan
- ✅ Tidak ada error PHP
- ✅ Tidak ada warning tentang PHP version
- ✅ Semua fitur theme berfungsi

### 9. Troubleshooting

**Problem: PHP 8.4 tidak muncul di Laragon menu**
- Solution: Pastikan nama folder sesuai format: `php-8.4.x-Win32-vs16-x64`
- Restart Laragon

**Problem: Extension tidak load**
- Solution: Edit php.ini, uncomment extension yang diperlukan
- Pastikan file extension (.dll) ada di folder `ext/`

**Problem: Apache tidak start**
- Solution: Cek error log di `D:\Installed\laragon\bin\apache\logs\error.log`
- Pastikan PHP version compatible dengan Apache

**Problem: WordPress error setelah upgrade**
- Solution: Clear WordPress cache
- Deactivate/reactivate theme
- Check error log: `wp-content/debug.log`

### 10. Verifikasi Final

**Checklist:**
- [ ] PHP 8.4 terinstall di Laragon
- [ ] Laragon menggunakan PHP 8.4 sebagai default
- [ ] Apache & MySQL running
- [ ] phpinfo() menunjukkan PHP 8.4
- [ ] WordPress bisa diakses
- [ ] Theme "Irvandoda Full SEO Lightweight" bisa diaktifkan
- [ ] Tidak ada error atau warning
- [ ] PHP 8.3.30 sudah dihapus (opsional)

## Alternatif: Install PHP 8.4 via Laragon Auto-Installer

**Langkah Cepat:**
1. Buka Laragon
2. Menu → **Tools** → **Quick add** → **PHP**
3. Pilih PHP 8.4 (jika tersedia)
4. Laragon akan download dan install otomatis
5. Switch ke PHP 8.4 via menu

**Note:** Fitur ini mungkin belum tersedia untuk PHP 8.4 jika masih terlalu baru.

## PHP 8.4 Features yang Digunakan Theme

Theme "Irvandoda Full SEO Lightweight" menggunakan:
- ✅ Strict types (`declare(strict_types=1)`)
- ✅ Return type declarations
- ✅ Match expressions
- ✅ Null coalescing assignment (`??=`)
- ✅ Union types (`int|float`)
- ✅ Nullable types (`?int`)
- ✅ Named arguments
- ✅ `str_contains()` function

Semua fitur ini memerlukan PHP 8.0+ dan optimal di PHP 8.4.

## Resources

**Official PHP Downloads:**
- https://windows.php.net/download/

**Laragon Documentation:**
- https://laragon.org/docs/

**PHP 8.4 Release Notes:**
- https://www.php.net/releases/8.4/en.php

**WordPress PHP Requirements:**
- https://wordpress.org/about/requirements/

## Support

Jika ada masalah:
- Email: irvando.d.a@gmail.com
- WhatsApp: +62 857-4747-6308
- Website: https://irvandoda.my.id

---

**Created:** 2026-04-21
**Author:** Irvando Demas Arifiandani
**Status:** Ready to Execute
