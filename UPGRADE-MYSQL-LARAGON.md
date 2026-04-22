# Upgrade MySQL di Laragon untuk PHP 8.5

## 📋 Informasi

**Current MySQL:** 8.4.3 (LTS)  
**Target MySQL:** 9.1.0 (Innovation) atau 8.4.3+ (LTS)  
**PHP Version:** 8.5.5  
**Laragon Path:** `D:\Installed\laragon`

## 🎯 Pilihan MySQL Version

### Option 1: MySQL 9.1.0 (Innovation Release) - RECOMMENDED
- **Latest Features:** Cutting-edge MySQL features
- **Performance:** Best performance improvements
- **Release Cycle:** Frequent updates (every 3 months)
- **Support:** Community support
- **Stability:** Stable but newer
- **Download:** https://dev.mysql.com/downloads/mysql/

### Option 2: MySQL 8.4.3 (LTS) - CURRENT
- **Long Term Support:** 5+ years support
- **Stability:** Production-proven
- **Updates:** Security & bug fixes only
- **Recommended for:** Production servers
- **Status:** Already installed ✅

### Option 3: MySQL 9.0.1 (Innovation)
- **Previous Innovation:** Stable innovation release
- **Features:** Modern features
- **Support:** Community support

## 🚀 Upgrade ke MySQL 9.1.0 (Recommended)

### Step 1: Download MySQL 9.1.0

1. **Visit:** https://dev.mysql.com/downloads/mysql/
2. **Select:**
   - Version: 9.1.0
   - Operating System: Microsoft Windows
   - OS Version: Windows (x86, 64-bit)
3. **Download:** `mysql-9.1.0-winx64.zip` (ZIP Archive)
4. **Size:** ~400 MB

**Direct Download Link:**
```
https://dev.mysql.com/get/Downloads/MySQL-9.1/mysql-9.1.0-winx64.zip
```

### Step 2: Backup Current MySQL

**CRITICAL: Backup database sebelum upgrade!**

```bash
# Stop Laragon services
# Via Laragon: Menu → Stop All

# Backup databases via phpMyAdmin
# 1. Open phpMyAdmin: http://localhost/phpmyadmin
# 2. Export → Export all databases
# 3. Save as: mysql-backup-8.4.3-[date].sql

# Or via command line:
cd D:\Installed\laragon\bin\mysql\mysql-8.4.3-winx64\bin
.\mysqldump.exe -u root -p --all-databases > D:\mysql-backup-8.4.3.sql
```

**Backup MySQL data directory:**
```bash
# Copy entire data folder
Copy-Item "D:\Installed\laragon\data\mysql" -Destination "D:\Installed\laragon\backup\mysql-8.4.3-data-backup" -Recurse
```

### Step 3: Extract MySQL 9.1.0

```bash
# Extract downloaded ZIP
# Extract to: C:\Users\irvan\Downloads\mysql-9.1-temp\

# Verify extraction
ls C:\Users\irvan\Downloads\mysql-9.1-temp\
# Should see: bin, lib, share, etc folders
```

### Step 4: Install MySQL 9.1.0 to Laragon

```bash
# Stop Laragon completely
# Via Laragon: Menu → Quit

# Copy MySQL 9.1.0 to Laragon
Copy-Item "C:\Users\irvan\Downloads\mysql-9.1-temp\mysql-9.1.0-winx64" -Destination "D:\Installed\laragon\bin\mysql\" -Recurse

# Verify installation
ls D:\Installed\laragon\bin\mysql\
# Should see: mysql-8.4.3-winx64, mysql-9.1.0-winx64
```

### Step 5: Copy Configuration

```bash
# Copy my.ini from old version to new version
Copy-Item "D:\Installed\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini" -Destination "D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\my.ini"

# Or create new my.ini (recommended)
# See configuration section below
```

### Step 6: Switch MySQL Version in Laragon

1. **Start Laragon**
2. **Right-click Laragon icon** in system tray
3. **Menu → MySQL → Version**
4. **Select:** `mysql-9.1.0-winx64`
5. **Laragon will restart automatically**

### Step 7: Upgrade MySQL System Tables

```bash
# Open Command Prompt as Administrator
cd D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin

# Run MySQL upgrade
.\mysql_upgrade.exe -u root -p

# Or use mysqlcheck (MySQL 9.1+)
.\mysqlcheck.exe -u root -p --all-databases --check-upgrade --auto-repair
```

### Step 8: Verify Installation

```bash
# Check MySQL version
& "D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin\mysql.exe" --version
# Expected: mysql  Ver 9.1.0 for Win64 on x86_64

# Test connection
& "D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin\mysql.exe" -u root -p
# Enter password and test queries:
# SHOW DATABASES;
# SELECT VERSION();
# EXIT;
```

### Step 9: Test with PHP 8.5

Create test file: `D:\Installed\laragon\www\test-mysql.php`

```php
<?php
// Test MySQL connection with PHP 8.5
$host = 'localhost';
$user = 'root';
$pass = 'root'; // Your MySQL password
$db = 'mysql';

try {
    // Test MySQLi
    $mysqli = new mysqli($host, $user, $pass, $db);
    echo "✅ MySQLi Connection: SUCCESS\n";
    echo "MySQL Version: " . $mysqli->server_info . "\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    $mysqli->close();
    
    // Test PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "✅ PDO Connection: SUCCESS\n";
    echo "PDO Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "\n";
    
} catch (Exception $e) {
    echo "❌ Connection Failed: " . $e->getMessage() . "\n";
}
?>
```

Visit: `http://localhost/test-mysql.php`

### Step 10: Remove Old MySQL Version (Optional)

**Only after confirming everything works!**

```bash
# Backup old version first
Move-Item "D:\Installed\laragon\bin\mysql\mysql-8.4.3-winx64" -Destination "D:\Installed\laragon\backup\mysql-8.4.3-winx64"

# Or delete completely
Remove-Item "D:\Installed\laragon\bin\mysql\mysql-8.4.3-winx64" -Recurse -Force
```

## ⚙️ MySQL 9.1.0 Configuration (my.ini)

Create/edit: `D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\my.ini`

```ini
[mysqld]
# Basic Settings
port=3306
basedir=D:/Installed/laragon/bin/mysql/mysql-9.1.0-winx64
datadir=D:/Installed/laragon/data/mysql
tmpdir=D:/Installed/laragon/tmp

# Character Set (UTF-8)
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# Performance Settings
max_connections=200
max_allowed_packet=64M
thread_cache_size=8
query_cache_size=0
query_cache_type=0

# InnoDB Settings
innodb_buffer_pool_size=512M
innodb_log_file_size=128M
innodb_flush_log_at_trx_commit=2
innodb_flush_method=normal

# Binary Logging (Optional - disable for development)
skip-log-bin

# Error Log
log_error=D:/Installed/laragon/data/mysql/mysql_error.log

# Slow Query Log (Optional)
slow_query_log=1
slow_query_log_file=D:/Installed/laragon/data/mysql/mysql_slow.log
long_query_time=2

# SQL Mode (Compatible)
sql_mode=STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION

# MySQL 9.1 Specific Settings
default_authentication_plugin=caching_sha2_password

[mysql]
default-character-set=utf8mb4

[client]
port=3306
default-character-set=utf8mb4
```

## 🔧 Troubleshooting

### Issue 1: MySQL Won't Start

**Solution:**
```bash
# Check error log
Get-Content "D:\Installed\laragon\data\mysql\mysql_error.log" -Tail 50

# Common fixes:
# 1. Delete ib_logfile* files
Remove-Item "D:\Installed\laragon\data\mysql\ib_logfile*"

# 2. Initialize data directory
cd D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin
.\mysqld.exe --initialize-insecure --datadir=D:\Installed\laragon\data\mysql
```

### Issue 2: Authentication Plugin Error

**Error:** `Authentication plugin 'caching_sha2_password' cannot be loaded`

**Solution:**
```sql
-- Connect to MySQL
mysql -u root -p

-- Change authentication method
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_password';
FLUSH PRIVILEGES;
```

### Issue 3: Port Already in Use

**Solution:**
```bash
# Check what's using port 3306
netstat -ano | findstr :3306

# Kill process (replace PID)
taskkill /PID [PID] /F

# Or change MySQL port in my.ini
# port=3307
```

### Issue 4: Data Directory Issues

**Solution:**
```bash
# Restore from backup
Remove-Item "D:\Installed\laragon\data\mysql" -Recurse -Force
Copy-Item "D:\Installed\laragon\backup\mysql-8.4.3-data-backup" -Destination "D:\Installed\laragon\data\mysql" -Recurse
```

### Issue 5: WordPress Connection Error

**Solution:**
```php
// wp-config.php
define('DB_HOST', 'localhost:3306'); // Specify port
// Or
define('DB_HOST', '127.0.0.1:3306'); // Use IP instead of localhost
```

## 📊 MySQL Version Comparison

| Feature | MySQL 8.4.3 (LTS) | MySQL 9.1.0 (Innovation) |
|---------|-------------------|--------------------------|
| **Release Date** | July 2024 | October 2024 |
| **Support** | 5+ years | Community |
| **Stability** | Production-ready | Stable |
| **Performance** | Excellent | Better |
| **New Features** | Stable features | Latest features |
| **PHP 8.5 Support** | ✅ Full | ✅ Full |
| **WordPress Support** | ✅ Full | ✅ Full |
| **Recommended For** | Production | Development |

## 🎯 MySQL 9.1.0 New Features

1. **Performance Improvements:**
   - Faster query execution
   - Better memory management
   - Improved InnoDB performance

2. **New SQL Features:**
   - Enhanced JSON functions
   - Better window functions
   - Improved CTEs (Common Table Expressions)

3. **Security Enhancements:**
   - Better authentication
   - Enhanced encryption
   - Improved privilege management

4. **Developer Features:**
   - Better error messages
   - Enhanced debugging
   - Improved monitoring

## 📝 Post-Upgrade Checklist

- [ ] MySQL 9.1.0 installed successfully
- [ ] Laragon switched to MySQL 9.1.0
- [ ] MySQL service starts without errors
- [ ] Can connect via command line
- [ ] Can connect via phpMyAdmin
- [ ] PHP 8.5 can connect (MySQLi & PDO)
- [ ] WordPress connects successfully
- [ ] All databases accessible
- [ ] Performance is good
- [ ] Old version backed up
- [ ] Configuration optimized

## 🔄 Rollback Plan

If something goes wrong:

```bash
# 1. Stop Laragon
# Via Laragon: Menu → Stop All

# 2. Switch back to MySQL 8.4.3
# Laragon → MySQL → Version → mysql-8.4.3-winx64

# 3. Restore data if needed
Remove-Item "D:\Installed\laragon\data\mysql" -Recurse -Force
Copy-Item "D:\Installed\laragon\backup\mysql-8.4.3-data-backup" -Destination "D:\Installed\laragon\data\mysql" -Recurse

# 4. Start Laragon
# Via Laragon: Menu → Start All
```

## 💡 Recommendations

### For Development:
- ✅ **Use MySQL 9.1.0** - Latest features, best performance
- ✅ Enable slow query log for optimization
- ✅ Use InnoDB for all tables
- ✅ Regular backups via phpMyAdmin

### For Production:
- ✅ **Use MySQL 8.4.3 LTS** - Long-term support, proven stability
- ✅ Optimize my.ini for production
- ✅ Enable binary logging
- ✅ Regular automated backups

### For WordPress:
- ✅ Both MySQL 8.4.3 and 9.1.0 work perfectly
- ✅ Use utf8mb4 character set
- ✅ InnoDB storage engine
- ✅ Optimize wp_options autoload

## 🔗 Useful Links

- **MySQL Downloads:** https://dev.mysql.com/downloads/mysql/
- **MySQL Documentation:** https://dev.mysql.com/doc/
- **MySQL 9.1 Release Notes:** https://dev.mysql.com/doc/relnotes/mysql/9.1/en/
- **Laragon Documentation:** https://laragon.org/docs/
- **PHP MySQL Extensions:** https://www.php.net/manual/en/book.mysqli.php

## 📞 Support

If you encounter issues:
1. Check error logs: `D:\Installed\laragon\data\mysql\mysql_error.log`
2. Check Laragon logs: `D:\Installed\laragon\logs\`
3. Test connection with test-mysql.php
4. Verify PHP extensions: `php -m | findstr mysql`

---

**Created:** 2026-04-21  
**Author:** Irvando Demas Arifiandani  
**Laragon Version:** Latest  
**PHP Version:** 8.5.5  
**Current MySQL:** 8.4.3  
**Target MySQL:** 9.1.0
