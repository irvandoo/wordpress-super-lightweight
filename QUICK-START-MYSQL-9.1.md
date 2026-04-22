# Quick Start: MySQL 9.1.0 Upgrade untuk Laragon

## 🚀 Cara Tercepat (Automated Script)

### Option 1: Gunakan PowerShell Script (RECOMMENDED)

```powershell
# 1. Buka PowerShell sebagai Administrator
# Right-click PowerShell → Run as Administrator

# 2. Navigate ke project folder
cd "D:\Installed\laragon\www\Active\wordpress super lightweight"

# 3. Jalankan script
.\upgrade-mysql-laragon.ps1

# 4. Ikuti instruksi di layar
# Script akan otomatis:
# - Backup MySQL current
# - Download MySQL 9.1.0
# - Extract dan install
# - Copy konfigurasi
# - Cleanup

# 5. Setelah selesai, switch di Laragon:
# Laragon → MySQL → Version → mysql-9.1.0-winx64
```

**Script akan handle semua proses otomatis!** ✅

---

## 📝 Cara Manual (Step by Step)

### Step 1: Download MySQL 9.1.0

**Download Link:**
```
https://dev.mysql.com/get/Downloads/MySQL-9.1/mysql-9.1.0-winx64.zip
```

**Atau kunjungi:**
- https://dev.mysql.com/downloads/mysql/
- Select: Windows (x86, 64-bit), ZIP Archive
- Download: ~400 MB

### Step 2: Backup Current MySQL

```powershell
# Stop Laragon
# Via Laragon: Menu → Stop All

# Backup via phpMyAdmin (RECOMMENDED)
# 1. Open: http://localhost/phpmyadmin
# 2. Export → Select All → Go
# 3. Save: mysql-backup-[date].sql

# Or backup data folder
Copy-Item "D:\Installed\laragon\data\mysql" -Destination "D:\Installed\laragon\backup\mysql-data-backup" -Recurse
```

### Step 3: Extract & Install

```powershell
# Extract ZIP
# Extract to: C:\Users\irvan\Downloads\mysql-9.1-temp\

# Copy to Laragon
Copy-Item "C:\Users\irvan\Downloads\mysql-9.1-temp\mysql-9.1.0-winx64" -Destination "D:\Installed\laragon\bin\mysql\" -Recurse

# Copy configuration
Copy-Item "D:\Installed\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini" -Destination "D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\my.ini"
```

### Step 4: Switch Version

1. **Start Laragon**
2. **Right-click** Laragon icon
3. **MySQL → Version**
4. **Select:** `mysql-9.1.0-winx64`
5. **Laragon restarts automatically**

### Step 5: Verify

```powershell
# Check version
& "D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin\mysql.exe" --version

# Test connection
# Open: http://localhost/phpmyadmin
# Check: MySQL version should show 9.1.0
```

**Done!** ✅

---

## ⚡ Super Quick (If You Trust Me)

```powershell
# One-liner (Run as Administrator)
cd "D:\Installed\laragon\www\Active\wordpress super lightweight"; .\upgrade-mysql-laragon.ps1
```

Tunggu 5-10 menit, selesai! 🎉

---

## 🔍 Verification Checklist

- [ ] MySQL 9.1.0 folder exists: `D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64`
- [ ] Laragon shows MySQL 9.1.0 in menu
- [ ] phpMyAdmin accessible: http://localhost/phpmyadmin
- [ ] MySQL version shows 9.1.0
- [ ] All databases visible
- [ ] Can create/edit databases
- [ ] WordPress connects successfully

---

## 🆘 Troubleshooting

### MySQL Won't Start?

```powershell
# Check error log
Get-Content "D:\Installed\laragon\data\mysql\mysql_error.log" -Tail 50

# Fix: Delete log files
Remove-Item "D:\Installed\laragon\data\mysql\ib_logfile*"

# Restart Laragon
```

### Can't Connect?

```powershell
# Reset root password
cd D:\Installed\laragon\bin\mysql\mysql-9.1.0-winx64\bin
.\mysql.exe -u root -p
# Enter current password

# Change password
ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';
FLUSH PRIVILEGES;
```

### Rollback to Old Version?

```powershell
# In Laragon:
# MySQL → Version → mysql-8.4.3-winx64

# Restore data if needed
Remove-Item "D:\Installed\laragon\data\mysql" -Recurse -Force
Copy-Item "D:\Installed\laragon\backup\mysql-data-backup" -Destination "D:\Installed\laragon\data\mysql" -Recurse
```

---

## 📊 What You Get

| Feature | MySQL 8.4.3 | MySQL 9.1.0 |
|---------|-------------|-------------|
| Performance | Fast | **Faster** |
| Features | Stable | **Latest** |
| PHP 8.5 Support | ✅ | ✅ |
| WordPress Support | ✅ | ✅ |
| Release | July 2024 | October 2024 |

---

## 💡 Tips

1. **Always backup** before upgrade
2. **Test thoroughly** after upgrade
3. **Keep old version** until confirmed working
4. **Monitor performance** for first few days
5. **Update WordPress** if needed

---

## 🎯 Recommended For

✅ **Development Environment** - Get latest features  
✅ **Testing New Features** - Try MySQL 9.1 innovations  
✅ **Performance Testing** - Benchmark improvements  
✅ **Learning** - Explore new MySQL capabilities  

⚠️ **Production** - Consider MySQL 8.4 LTS for stability

---

## 📞 Need Help?

- **Error Logs:** `D:\Installed\laragon\data\mysql\mysql_error.log`
- **Laragon Logs:** `D:\Installed\laragon\logs\`
- **MySQL Docs:** https://dev.mysql.com/doc/
- **Laragon Docs:** https://laragon.org/docs/

---

**Created:** 2026-04-21  
**Author:** Irvando Demas Arifiandani  
**Current MySQL:** 8.4.3  
**Target MySQL:** 9.1.0  
**PHP Version:** 8.5.5  
**Estimated Time:** 10-15 minutes
