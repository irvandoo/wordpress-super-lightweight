# ============================================================================
# MySQL 9.1.0 Upgrade Script for Laragon
# ============================================================================
# Author: Irvando Demas Arifiandani
# Date: 2026-04-21
# Purpose: Automated MySQL upgrade for Laragon with PHP 8.5 support
# ============================================================================

# Requires Administrator privileges
#Requires -RunAsAdministrator

# Configuration
$mysqlVersion = "9.1.0"
$mysqlFileName = "mysql-$mysqlVersion-winx64"
$downloadUrl = "https://dev.mysql.com/get/Downloads/MySQL-9.1/$mysqlFileName.zip"
$tempDir = "$env:TEMP\mysql-upgrade"
$laragonPath = "D:\Installed\laragon"
$mysqlBinPath = "$laragonPath\bin\mysql"
$backupPath = "$laragonPath\backup"
$dataPath = "$laragonPath\data\mysql"

# Colors for output
function Write-Success { Write-Host $args -ForegroundColor Green }
function Write-Info { Write-Host $args -ForegroundColor Cyan }
function Write-Warning { Write-Host $args -ForegroundColor Yellow }
function Write-Error { Write-Host $args -ForegroundColor Red }

# ============================================================================
# Step 1: Pre-flight Checks
# ============================================================================

Write-Info "`n=========================================="
Write-Info "MySQL 9.1.0 Upgrade for Laragon"
Write-Info "=========================================="

Write-Info "`nStep 1: Pre-flight checks..."

# Check if Laragon is installed
if (-not (Test-Path $laragonPath)) {
    Write-Error "❌ Laragon not found at: $laragonPath"
    Write-Error "Please update the `$laragonPath variable in this script."
    exit 1
}
Write-Success "✅ Laragon found: $laragonPath"

# Check if MySQL directory exists
if (-not (Test-Path $mysqlBinPath)) {
    Write-Error "❌ MySQL directory not found: $mysqlBinPath"
    exit 1
}
Write-Success "✅ MySQL directory found: $mysqlBinPath"

# Check current MySQL version
$currentMysql = Get-ChildItem $mysqlBinPath | Where-Object { $_.Name -like "mysql-*" } | Select-Object -First 1
if ($currentMysql) {
    Write-Info "📦 Current MySQL: $($currentMysql.Name)"
} else {
    Write-Warning "⚠️  No MySQL installation found"
}

# Check if MySQL 9.1.0 already installed
if (Test-Path "$mysqlBinPath\$mysqlFileName") {
    Write-Warning "⚠️  MySQL 9.1.0 already installed!"
    $continue = Read-Host "Continue anyway? (y/n)"
    if ($continue -ne "y") {
        Write-Info "Upgrade cancelled."
        exit 0
    }
}

# ============================================================================
# Step 2: Backup Current MySQL
# ============================================================================

Write-Info "`nStep 2: Backing up current MySQL..."

# Create backup directory
if (-not (Test-Path $backupPath)) {
    New-Item -ItemType Directory -Path $backupPath -Force | Out-Null
}

# Backup current MySQL installation
if ($currentMysql) {
    $backupName = "$($currentMysql.Name)-backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
    $backupFullPath = "$backupPath\$backupName"
    
    Write-Info "📦 Backing up: $($currentMysql.Name)"
    Write-Info "📁 To: $backupFullPath"
    
    try {
        Copy-Item "$mysqlBinPath\$($currentMysql.Name)" -Destination $backupFullPath -Recurse -Force
        Write-Success "✅ MySQL installation backed up"
    } catch {
        Write-Error "❌ Backup failed: $_"
        exit 1
    }
}

# Backup MySQL data directory
if (Test-Path $dataPath) {
    $dataBackupName = "mysql-data-backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
    $dataBackupFullPath = "$backupPath\$dataBackupName"
    
    Write-Info "📦 Backing up MySQL data..."
    Write-Info "📁 To: $dataBackupFullPath"
    
    try {
        Copy-Item $dataPath -Destination $dataBackupFullPath -Recurse -Force
        Write-Success "✅ MySQL data backed up"
    } catch {
        Write-Error "❌ Data backup failed: $_"
        Write-Warning "⚠️  Continuing anyway, but be careful!"
    }
}

# ============================================================================
# Step 3: Download MySQL 9.1.0
# ============================================================================

Write-Info "`nStep 3: Downloading MySQL 9.1.0..."

# Create temp directory
if (-not (Test-Path $tempDir)) {
    New-Item -ItemType Directory -Path $tempDir -Force | Out-Null
}

$zipFile = "$tempDir\$mysqlFileName.zip"

# Check if already downloaded
if (Test-Path $zipFile) {
    Write-Info "📦 MySQL 9.1.0 already downloaded"
    $redownload = Read-Host "Re-download? (y/n)"
    if ($redownload -eq "y") {
        Remove-Item $zipFile -Force
    }
}

# Download MySQL 9.1.0
if (-not (Test-Path $zipFile)) {
    Write-Info "⬇️  Downloading MySQL 9.1.0..."
    Write-Info "📥 From: $downloadUrl"
    Write-Info "💾 Size: ~400 MB (this may take a while)"
    
    try {
        # Use BITS transfer for better download
        Import-Module BitsTransfer
        Start-BitsTransfer -Source $downloadUrl -Destination $zipFile -Description "Downloading MySQL 9.1.0"
        Write-Success "✅ Download complete"
    } catch {
        Write-Warning "⚠️  BITS transfer failed, trying WebClient..."
        try {
            $webClient = New-Object System.Net.WebClient
            $webClient.DownloadFile($downloadUrl, $zipFile)
            Write-Success "✅ Download complete"
        } catch {
            Write-Error "❌ Download failed: $_"
            Write-Info "Please download manually from: https://dev.mysql.com/downloads/mysql/"
            exit 1
        }
    }
}

# ============================================================================
# Step 4: Extract MySQL 9.1.0
# ============================================================================

Write-Info "`nStep 4: Extracting MySQL 9.1.0..."

$extractPath = "$tempDir\extracted"

if (Test-Path $extractPath) {
    Remove-Item $extractPath -Recurse -Force
}

try {
    Write-Info "📦 Extracting ZIP file..."
    Expand-Archive -Path $zipFile -DestinationPath $extractPath -Force
    Write-Success "✅ Extraction complete"
} catch {
    Write-Error "❌ Extraction failed: $_"
    exit 1
}

# ============================================================================
# Step 5: Install MySQL 9.1.0 to Laragon
# ============================================================================

Write-Info "`nStep 5: Installing MySQL 9.1.0 to Laragon..."

$extractedMysql = Get-ChildItem $extractPath | Where-Object { $_.Name -like "mysql-*" } | Select-Object -First 1

if (-not $extractedMysql) {
    Write-Error "❌ Extracted MySQL folder not found"
    exit 1
}

$targetPath = "$mysqlBinPath\$mysqlFileName"

try {
    Write-Info "📁 Copying to: $targetPath"
    Copy-Item "$extractPath\$($extractedMysql.Name)" -Destination $targetPath -Recurse -Force
    Write-Success "✅ MySQL 9.1.0 installed to Laragon"
} catch {
    Write-Error "❌ Installation failed: $_"
    exit 1
}

# ============================================================================
# Step 6: Copy Configuration
# ============================================================================

Write-Info "`nStep 6: Configuring MySQL 9.1.0..."

# Copy my.ini from old version if exists
if ($currentMysql -and (Test-Path "$mysqlBinPath\$($currentMysql.Name)\my.ini")) {
    Write-Info "📋 Copying my.ini from old version..."
    Copy-Item "$mysqlBinPath\$($currentMysql.Name)\my.ini" -Destination "$targetPath\my.ini" -Force
    Write-Success "✅ Configuration copied"
} else {
    Write-Info "📋 Creating default my.ini..."
    
    $myIniContent = @"
[mysqld]
port=3306
basedir=$($targetPath.Replace('\', '/'))
datadir=$($dataPath.Replace('\', '/'))
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
max_connections=200
max_allowed_packet=64M
innodb_buffer_pool_size=512M
skip-log-bin
sql_mode=STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION

[mysql]
default-character-set=utf8mb4

[client]
port=3306
default-character-set=utf8mb4
"@
    
    Set-Content -Path "$targetPath\my.ini" -Value $myIniContent -Force
    Write-Success "✅ Default configuration created"
}

# ============================================================================
# Step 7: Cleanup
# ============================================================================

Write-Info "`nStep 7: Cleaning up..."

try {
    Remove-Item $tempDir -Recurse -Force
    Write-Success "✅ Temporary files cleaned"
} catch {
    Write-Warning "⚠️  Could not clean temp files: $_"
}

# ============================================================================
# Step 8: Final Instructions
# ============================================================================

Write-Success "`n=========================================="
Write-Success "✅ MySQL 9.1.0 Installation Complete!"
Write-Success "=========================================="

Write-Info "`n📋 Next Steps:"
Write-Info "1. Open Laragon"
Write-Info "2. Right-click Laragon icon → MySQL → Version"
Write-Info "3. Select: mysql-$mysqlVersion-winx64"
Write-Info "4. Laragon will restart automatically"
Write-Info "5. Verify installation:"
Write-Info "   - Open phpMyAdmin: http://localhost/phpmyadmin"
Write-Info "   - Check MySQL version"

Write-Info "`n🔧 Verify via Command Line:"
Write-Info "   & `"$targetPath\bin\mysql.exe`" --version"

Write-Info "`n📦 Backup Locations:"
if ($currentMysql) {
    Write-Info "   MySQL: $backupPath\$backupName"
}
Write-Info "   Data: $backupPath\$dataBackupName"

Write-Info "`n⚠️  Important:"
Write-Info "   - Test all databases after switching"
Write-Info "   - Run mysql_upgrade if needed"
Write-Info "   - Keep backups until confirmed working"

Write-Info "`n🔄 Rollback (if needed):"
Write-Info "   1. Laragon → MySQL → Version → Select old version"
Write-Info "   2. Restore data from backup if needed"

Write-Success "`n✅ Installation script completed successfully!"
Write-Info "`nPress any key to exit..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
