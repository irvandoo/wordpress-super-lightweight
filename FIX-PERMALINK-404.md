# 🔧 Fix Permalink 404 Error - WordPress Super Lightweight

## ❌ Masalah

Ketika mengakses artikel, muncul error:
```
Not Found
The requested URL was not found on this server.
```

## 🔍 Penyebab

Masalah ini terjadi karena **Apache mod_rewrite** tidak bisa membaca file `.htaccess` karena setting `AllowOverride` di Apache config masih `None`.

---

## ✅ SOLUSI 1: Edit Apache Config (RECOMMENDED)

### Langkah-langkah:

1. **Buka Laragon**
   - Klik kanan icon Laragon di system tray
   - Pilih: **Apache → httpd.conf**

2. **Edit httpd.conf**
   - Cari baris (sekitar line 230-250):
   ```apache
   <Directory "D:/Installed/laragon/www">
   ```

3. **Tambahkan/Ubah AllowOverride**
   - Di dalam block `<Directory>` tersebut, cari atau tambahkan:
   ```apache
   <Directory "D:/Installed/laragon/www">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>
   ```

4. **Save File** (Ctrl+S)

5. **Restart Apache**
   - Klik kanan icon Laragon
   - Pilih: **Apache → Restart**
   - Atau klik tombol "Stop All" lalu "Start All"

6. **Flush Permalink di WordPress**
   - Login ke WordPress Admin
   - Go to: **Settings → Permalinks**
   - Klik **Save Changes** (tanpa mengubah apapun)

7. **Test Artikel**
   - Akses artikel Anda
   - Seharusnya sudah bisa diakses!

---

## ✅ SOLUSI 2: Gunakan Plain Permalink (TEMPORARY)

Jika Solusi 1 tidak bisa dilakukan, gunakan permalink Plain sementara:

1. **Login WordPress Admin**

2. **Go to Settings → Permalinks**

3. **Pilih "Plain"**
   - Format: `/?p=123`

4. **Save Changes**

5. **Test Artikel**
   - URL akan berubah menjadi: `http://localhost/active/wordpress%20super%20lightweight/?p=1`
   - Artikel bisa diakses

**Kekurangan:**
- URL tidak SEO-friendly
- Tidak ada slug artikel di URL

---

## ✅ SOLUSI 3: Cek & Fix .htaccess Manual

### 1. Cek File .htaccess

Pastikan file `.htaccess` ada di root WordPress:
```
D:\Installed\laragon\www\Active\wordpress super lightweight\.htaccess
```

### 2. Isi .htaccess yang Benar

File `.htaccess` harus berisi:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /active/wordpress%20super%20lightweight/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /active/wordpress%20super%20lightweight/index.php [L]
</IfModule>
# END WordPress
```

### 3. Set Permission

- Right-click file `.htaccess`
- Properties → Security
- Pastikan "Read" dan "Write" enabled

### 4. Flush Permalink

- Go to: **Settings → Permalinks**
- Klik **Save Changes**

---

## ✅ SOLUSI 4: Pindah ke Folder Tanpa Spasi

Folder dengan spasi (`wordpress super lightweight`) bisa menyebabkan masalah.

### Langkah-langkah:

1. **Rename Folder**
   ```
   D:\Installed\laragon\www\Active\wordpress super lightweight
   →
   D:\Installed\laragon\www\Active\wordpress-super-lightweight
   ```

2. **Update wp-config.php**
   - Buka `wp-config.php`
   - Update `WP_HOME` dan `WP_SITEURL` (jika ada)

3. **Update Database**
   - Buka phpMyAdmin atau MySQL
   - Run query:
   ```sql
   UPDATE wp_options 
   SET option_value = 'http://localhost/active/wordpress-super-lightweight' 
   WHERE option_name IN ('siteurl', 'home');
   ```

4. **Update .htaccess**
   - Edit `.htaccess`
   - Ubah `RewriteBase` menjadi:
   ```apache
   RewriteBase /active/wordpress-super-lightweight/
   ```
   - Ubah `RewriteRule` terakhir menjadi:
   ```apache
   RewriteRule . /active/wordpress-super-lightweight/index.php [L]
   ```

5. **Flush Permalink**
   - Settings → Permalinks → Save Changes

---

## 🧪 Testing

### Test 1: Cek mod_rewrite
Buka: `http://localhost/active/wordpress%20super%20lightweight/wp-admin/options-permalink.php`

Jika halaman terbuka, mod_rewrite kemungkinan OK.

### Test 2: Cek .htaccess
Buat file `test-htaccess.php` di root:
```php
<?php
if (file_exists('.htaccess')) {
    echo "✅ .htaccess exists<br>";
    echo "Size: " . filesize('.htaccess') . " bytes<br>";
    echo "Writable: " . (is_writable('.htaccess') ? 'Yes' : 'No') . "<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
} else {
    echo "❌ .htaccess NOT found";
}
?>
```

Akses: `http://localhost/active/wordpress%20super%20lightweight/test-htaccess.php`

### Test 3: Cek Artikel
Akses artikel dengan URL pretty:
```
http://localhost/active/wordpress%20super%20lightweight/halo-dunia/
```

Jika masih 404, gunakan Solusi 1 (Edit Apache Config).

---

## 📋 Checklist

- [ ] Apache mod_rewrite enabled
- [ ] AllowOverride set to "All" di httpd.conf
- [ ] File .htaccess ada dan berisi rewrite rules
- [ ] File .htaccess writable (permission 644)
- [ ] Permalink structure di WordPress bukan "Plain"
- [ ] Sudah flush permalink (Save Changes di Settings → Permalinks)
- [ ] Apache sudah di-restart

---

## 🆘 Masih Bermasalah?

### Quick Fix: Gunakan Plain Permalink
1. Settings → Permalinks
2. Pilih "Plain"
3. Save Changes

URL akan jadi: `/?p=123` (tidak SEO-friendly tapi berfungsi)

### Atau: Gunakan Plugin
Install plugin: **Permalink Manager Lite**
- Auto-fix permalink issues
- Custom permalink structure
- Redirect management

---

## 💡 Tips

1. **Selalu backup** sebelum edit config
2. **Restart Apache** setelah edit httpd.conf
3. **Flush permalink** setelah perubahan
4. **Gunakan folder tanpa spasi** untuk menghindari masalah
5. **Check error log** di `D:\Installed\laragon\bin\apache\logs\error.log`

---

## 📞 Support

Jika masih bermasalah, cek:
- Apache error log
- PHP error log
- WordPress debug.log

Enable WordPress debug mode di `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Lalu cek file: `wp-content/debug.log`
