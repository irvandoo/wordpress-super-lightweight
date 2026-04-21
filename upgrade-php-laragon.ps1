# PowerShell Script untuk Upgrade PHP di Laragon ke versi 8.4
# Author: Irvando Demas Arifiandani
# Date: 2026-04-21

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Laragon PHP 8.4 Upgrade Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Konfigurasi
$laragonPath = "D:\Installed\laragon"
$phpBinPath = "$laragonPath\bin\php"
$currentPhpVersion = "php-8.3.30-Win32-vs16-x64"
$targetPhpVersion = "php-8.4.2-Win32-vs16-x64"  # Update sesuai versi terbaru
$downloadUrl = "https://windows.php.net/downloads/releases/$targetPhpVersion.zip"
$tempPath = "$env:TEMP\php-upgrade"

# Fungsi untuk cek apakah Laragon running
function Test-LaragonRunning {
    $apache = Get-Process -Name "httpd" -ErrorAction SilentlyContinue
    $mysql = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
    return ($apache -or $mysql)
}

# Fungsi untuk stop Laragon
function Stop-Laragon {
    Write-Host "Stopping Laragon services..." -ForegroundColor Yellow
    
    # Stop Apache
    $apache = Get-Process -Name "httpd" -ErrorAction SilentlyContinue
    if ($apache) {
        Stop-Process -Name "httpd" -Force
        Write-Host "  - Apache stopped" -ForegroundColor Green
    }
    
    # Stop MySQL
    $mysql = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
    if ($mysql) {
        Stop-Process -Name "mysqld" -Force
        Write-Host "  - MySQL stopped" -ForegroundColor Green
    }
    
    Start-Sleep -Seconds 2
}

# Cek current PHP version
Write-Host "Checking current PHP version..." -ForegroundColor Yellow
if (Test-Path "$phpBinPath\$currentPhpVersion") {
    Write-Host "  Current: $currentPhpVersion" -ForegroundColor Green
} else {
    Write-Host "  Warning: Expected PHP version not found" -ForegroundColor Red
    Write-Host "  Looking for installed versions..." -ForegroundColor Yellow
    Get-ChildItem -Path $phpBinPath -Directory | ForEach-Object {
        Write-Host "    - $($_.Name)" -ForegroundColor Cyan
    }
}

# Cek apakah PHP 8.4 sudah terinstall
Write-Host ""
Write-Host "Checking for PHP 8.4..." -ForegroundColor Yellow
$php84Installed = Get-ChildItem -Path $phpBinPath -Directory | Where-Object { $_.Name -like "php-8.4*" }

if ($php84Installed) {
    Write-Host "  PHP 8.4 already installed: $($php84Installed.Name)" -ForegroundColor Green
    Write-Host ""
    $useExisting = Read-Host "Use existing PHP 8.4 installation? (Y/N)"
    
    if ($useExisting -eq "Y" -or $useExisting -eq "y") {
        $targetPhpVersion = $php84Installed.Name
        Write-Host "  Using: $targetPhpVersion" -ForegroundColor Green
        $skipDownload = $true
    } else {
        $skipDownload = $false
    }
} else {
    Write-Host "  PHP 8.4 not found. Will download and install." -ForegroundColor Yellow
    $skipDownload = $false
}

# Download PHP 8.4 (jika belum ada)
if (-not $skipDownload) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "  MANUAL DOWNLOAD REQUIRED" -ForegroundColor Yellow
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Please download PHP 8.4 manually:" -ForegroundColor Yellow
    Write-Host "1. Visit: https://windows.php.net/download/" -ForegroundColor Cyan
    Write-Host "2. Download: PHP 8.4.x Thread Safe (TS) x64" -ForegroundColor Cyan
    Write-Host "3. Choose: VS16 or VS17 version" -ForegroundColor Cyan
    Write-Host "4. Save to: $tempPath" -ForegroundColor Cyan
    Write-Host ""
    
    # Buat temp directory
    if (-not (Test-Path $tempPath)) {
        New-Item -ItemType Directory -Path $tempPath | Out-Null
    }
    
    Write-Host "Opening download page in browser..." -ForegroundColor Yellow
    Start-Process "https://windows.php.net/download/"
    
    Write-Host ""
    Read-Host "Press Enter after downloading the ZIP file to $tempPath"
    
    # Cari file ZIP di temp path
    $zipFile = Get-ChildItem -Path $tempPath -Filter "php-8.4*.zip" | Select-Object -First 1
    
    if (-not $zipFile) {
        Write-Host "Error: PHP 8.4 ZIP file not found in $tempPath" -ForegroundColor Red
        Write-Host "Please download manually and place in: $tempPath" -ForegroundColor Yellow
        exit 1
    }
    
    Write-Host "Found: $($zipFile.Name)" -ForegroundColor Green
    
    # Extract ZIP
    Write-Host ""
    Write-Host "Extracting PHP 8.4..." -ForegroundColor Yellow
    $extractPath = "$tempPath\php-8.4-extracted"
    
    if (Test-Path $extractPath) {
        Remove-Item -Path $extractPath -Recurse -Force
    }
    
    Expand-Archive -Path $zipFile.FullName -DestinationPath $extractPath -Force
    Write-Host "  Extracted successfully" -ForegroundColor Green
    
    # Detect version dari folder
    $phpExe = Get-ChildItem -Path $extractPath -Filter "php.exe" -Recurse | Select-Object -First 1
    if ($phpExe) {
        $versionOutput = & $phpExe.FullName -v
        if ($versionOutput -match "PHP (\d+\.\d+\.\d+)") {
            $detectedVersion = $matches[1]
            $targetPhpVersion = "php-$detectedVersion-Win32-vs16-x64"
            Write-Host "  Detected version: $detectedVersion" -ForegroundColor Green
        }
    }
    
    # Copy ke Laragon
    Write-Host ""
    Write-Host "Installing PHP 8.4 to Laragon..." -ForegroundColor Yellow
    
    $targetPath = "$phpBinPath\$targetPhpVersion"
    
    if (Test-Path $targetPath) {
        Write-Host "  Removing existing installation..." -ForegroundColor Yellow
        Remove-Item -Path $targetPath -Recurse -Force
    }
    
    Copy-Item -Path $extractPath -Destination $targetPath -Recurse -Force
    Write-Host "  Installed to: $targetPath" -ForegroundColor Green
}

# Stop Laragon jika running
Write-Host ""
if (Test-LaragonRunning) {
    Write-Host "Laragon is running. Stopping services..." -ForegroundColor Yellow
    Stop-Laragon
} else {
    Write-Host "Laragon services not running." -ForegroundColor Green
}

# Backup PHP 8.3 (opsional)
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Backup & Cleanup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$backupOldPhp = Read-Host "Backup PHP 8.3 before removing? (Y/N)"

if ($backupOldPhp -eq "Y" -or $backupOldPhp -eq "y") {
    $backupPath = "$laragonPath\backup\php-backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
    Write-Host "Creating backup..." -ForegroundColor Yellow
    
    if (-not (Test-Path "$laragonPath\backup")) {
        New-Item -ItemType Directory -Path "$laragonPath\backup" | Out-Null
    }
    
    Copy-Item -Path "$phpBinPath\$currentPhpVersion" -Destination $backupPath -Recurse -Force
    Write-Host "  Backup created: $backupPath" -ForegroundColor Green
}

# Hapus PHP 8.3
Write-Host ""
$removeOldPhp = Read-Host "Remove PHP 8.3? (Y/N)"

if ($removeOldPhp -eq "Y" -or $removeOldPhp -eq "y") {
    Write-Host "Removing PHP 8.3..." -ForegroundColor Yellow
    
    if (Test-Path "$phpBinPath\$currentPhpVersion") {
        Remove-Item -Path "$phpBinPath\$currentPhpVersion" -Recurse -Force
        Write-Host "  PHP 8.3 removed" -ForegroundColor Green
    } else {
        Write-Host "  PHP 8.3 not found (already removed?)" -ForegroundColor Yellow
    }
}

# Konfigurasi php.ini
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Configure PHP 8.4" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$phpIniPath = "$phpBinPath\$targetPhpVersion\php.ini"
$phpIniDevPath = "$phpBinPath\$targetPhpVersion\php.ini-development"

if (-not (Test-Path $phpIniPath) -and (Test-Path $phpIniDevPath)) {
    Write-Host "Creating php.ini from php.ini-development..." -ForegroundColor Yellow
    Copy-Item -Path $phpIniDevPath -Destination $phpIniPath -Force
    Write-Host "  php.ini created" -ForegroundColor Green
}

Write-Host ""
Write-Host "PHP 8.4 configuration file: $phpIniPath" -ForegroundColor Cyan
Write-Host ""
Write-Host "Recommended settings for WordPress:" -ForegroundColor Yellow
Write-Host "  - memory_limit = 256M" -ForegroundColor Cyan
Write-Host "  - max_execution_time = 300" -ForegroundColor Cyan
Write-Host "  - post_max_size = 128M" -ForegroundColor Cyan
Write-Host "  - upload_max_filesize = 128M" -ForegroundColor Cyan
Write-Host "  - Enable extensions: curl, gd, mbstring, mysqli, openssl, pdo_mysql, zip" -ForegroundColor Cyan
Write-Host ""

$editPhpIni = Read-Host "Open php.ini for editing? (Y/N)"

if ($editPhpIni -eq "Y" -or $editPhpIni -eq "y") {
    notepad $phpIniPath
}

# Summary
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Installation Summary" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "PHP 8.4 Location: $phpBinPath\$targetPhpVersion" -ForegroundColor Green
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Yellow
Write-Host "1. Start Laragon" -ForegroundColor Cyan
Write-Host "2. Right-click Laragon tray icon" -ForegroundColor Cyan
Write-Host "3. Go to: PHP -> Version -> $targetPhpVersion" -ForegroundColor Cyan
Write-Host "4. Laragon will restart automatically" -ForegroundColor Cyan
Write-Host "5. Verify: Menu -> PHP -> phpinfo" -ForegroundColor Cyan
Write-Host "6. Test WordPress theme activation" -ForegroundColor Cyan
Write-Host ""
Write-Host "Verification Commands:" -ForegroundColor Yellow
Write-Host "  php -v" -ForegroundColor Cyan
Write-Host "  http://localhost/" -ForegroundColor Cyan
Write-Host ""

# Cleanup temp files
if (Test-Path $tempPath) {
    $cleanupTemp = Read-Host "Remove temporary files? (Y/N)"
    if ($cleanupTemp -eq "Y" -or $cleanupTemp -eq "y") {
        Remove-Item -Path $tempPath -Recurse -Force
        Write-Host "Temporary files removed" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Upgrade Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Please start Laragon and switch to PHP 8.4" -ForegroundColor Yellow
Write-Host ""

Read-Host "Press Enter to exit"
