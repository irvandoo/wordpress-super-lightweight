# ============================================================================
# MySQL 9.1.0 Manual Upgrade Script (No Admin Required)
# ============================================================================
# Author: Irvando Demas Arifiandani
# Date: 2026-04-21
# Purpose: Manual MySQL upgrade steps without admin privileges
# ============================================================================

# Configuration
$mysqlVersion = "9.1.0"
$mysqlFileName = "mysql-$mysqlVersion-winx64"
$downloadUrl = "https://dev.mysql.com/get/Downloads/MySQL-9.1/$mysqlFileName.zip"
$tempDir = "$env:TEMP\mysql-upgrade"
$laragonPath = "D:\Installed\laragon"
$mysqlBinPath = "$laragonPath\bin\mysql"

# Colors for output
function Write-Success { Write-Host $args -ForegroundColor Green }
function Write-Info { Write-Host $args -ForegroundColor Cyan }
function Write-Warning { Write-Host $args -ForegroundColor Yellow }
function Write-Error { Write-Host $args -ForegroundColor Red }
function Write-Step { Write-Host $args -ForegroundColor Magenta }

Write-Info "`n=========================================="
Write-Info "MySQL 9.1.0 Manual Upgrade Guide"
Write-Info "=========================================="

Write-Warning "`n⚠️  IMPORTANT: Stop Laragon first!"
Write-Warning "   Right-click Laragon → Stop All"
$continue = Read-Host "`nHave you stopped Laragon? (y/n)"
if ($continue -ne "y") {
    Write-Error "Please stop Laragon first, then run this script again."
    exit 1
}

# ============================================================================
# Step 1: Check Current Installation
# ============================================================================

Write-Step "`n📋 Step 1: Checking current installation..."

if (-not (Test-Path $laragonPath)) {
    Write-Error "❌ Laragon not found at: $laragonPath"
    Write-Info "Please update the path in this script if Laragon is installed elsewhere."
    exit 1
}
Write-Success "✅ Laragon found: $laragonPath"

if (-not (Test-Path $mysqlBinPath)) {
    Write-Error "❌ MySQL directory not found: $mysqlBinPath"
    exit 1
}
Write-Success "✅ MySQL directory found: $mysqlBinPath"

$currentMysql = Get-ChildItem $mysqlBinPath | Where-Object { $_.Name -like "mysql-*" } | Select-Object -First 1
if ($currentMysql) {
    Write-Info "📦 Current MySQL: $($currentMysql.Name)"
} else {
    Write-Warning "⚠️  No MySQL installation found"
}

if (Test-Path "$mysqlBinPath\$mysqlFileName") {
    Write-Warning "⚠️  MySQL 9.1.0 already installed at: $mysqlBinPath\$mysqlFileName"
    $continue = Read-Host "Continue anyway? (y/n)"
    if ($continue -ne "y") {
        Write-Info "Upgrade cancelled."
        exit 0
    }
}

# ============================================================================
# Step 2: Download MySQL 9.1.0
# ============================================================================

Write-Step "`n📥 Step 2: Downloading MySQL 9.1.0..."

if (-not (Test-Path $tempDir)) {
    New-Item -ItemType Directory -Path $tempDir -Force | Out-Null
}

$zipFile = "$tempDir\$mysqlFileName.zip"

if (Test-Path $zipFile) {
    Write-Info "📦 MySQL 9.1.0 already downloaded: $zipFile"
    $redownload = Read-Host "Re-download? (y/n)"
    if ($redownload -eq "y") {
        Remove-Item $zipFile -Force
    }
}

if (-not (Test-Path $zipFile)) {
    Write-Info "⬇️  Downloading MySQL 9.1.0..."
    Write-Info "📥 URL: $downloadUrl"
    Write-Info "💾 Size: ~400 MB"
    Write-Warning "⏳ This may take 5-10 minutes depending on your internet speed..."
    
    try {
        # Try BITS transfer first (faster and resumable)
        Write-Info "🚀 Using BITS transfer for faster download..."
        Import-Module BitsTransfer -ErrorAction SilentlyContinue
        Start-BitsTransfer -Source $downloadUrl -Destination $zipFile -Description "MySQL 9.1.0 Download" -Priority High
        Write-Success "✅ Download completed using BITS"
    } catch {
        Write-Warning "⚠️  BITS transfer failed, trying alternative method..."
        try {
            # Fallback to WebClient
            $webClient = New-Object System.Net.WebClient
            $webClient.DownloadProgressChanged += {
                $percent = [math]::Round(($_.BytesReceived / $_.TotalBytesToReceive) * 100, 2)
                Write-Progress -Activity "Downloading MySQL 9.1.0" -Status "$percent% Complete" -PercentComplete $percent
            }
            $webClient.DownloadFile($downloadUrl, $zipFile)
            Write-Progress -Activity "Downloading MySQL 9.1.0" -Completed
            Write-Success "✅ Download completed using WebClient"
        } catch {
            Write-Error "❌ Download failed: $_"
            Write-Info "`n🌐 Manual Download Instructions:"
            Write-Info "1. Open browser and go to: https://dev.mysql.com/downloads/mysql/"
            Write-Info "2. Select: MySQL Community Server 9.1.0"
            Write-Info "3. Select: Windows (x86, 64-bit), ZIP Archive"
            Write-Info "4. Download and save as: $zipFile"
            Write-Info "5. Run this script again"
            exit 1
        }
    }
}

# Verify download
if (-not (Test-Path $zipFile)) {
    Write-Error "❌ Download verification failed. File not found: $zipFile"
    exit 1
}

$fileSize = (Get-Item $zipFile).Length / 1MB
Write-Success "✅ Download verified. Size: $([math]::Round($fileSize, 2)) MB"

# ============================================================================
# Step 3: Extract MySQL 9.1.0
# ============================================================================

Write-Step "`n📦 Step 3: Extracting MySQL 9.1.0..."

$extractPath = "$tempDir\extracted"

if (Test-Path $extractPath) {
    Write-Info "🗑️  Cleaning previous extraction..."
    Remove-Item $extractPath -Recurse -Force
}

try {
    Write-Info "📂 Extracting to: $extractPath"
    Write-Info "⏳ This may take 2-3 minutes..."
    
    # Extract with progress
    Add-Type -AssemblyName System.IO.Compression.FileSystem
    [System.IO.Compression.ZipFile]::ExtractToDirectory($zipFile, $extractPath)
    
    Write-Success "✅ Extraction completed"
} catch {
    Write-Error "❌ Extraction failed: $_"
    Write-Info "`n🛠️  Manual Extraction Instructions:"
    Write-Info "1. Right-click on: $zipFile"
    Write-Info "2. Select 'Extract All...'"
    Write-Info "3. Extract to: $extractPath"
    Write-Info "4. Run this script again"
    exit 1
}

# Verify extraction
$extractedMysql = Get-ChildItem $extractPath | Where-Object { $_.Name -like "mysql-*" } | Select-Object -First 1
if (-not $extractedMysql) {
    Write-Error "❌ Extracted MySQL folder not found in: $extractPath"
    Write-Info "Expected folder name like: mysql-9.1.0-winx64"
    exit 1
}
Write-Success "✅ Extracted folder found: $($extractedMysql.Name)"

# ============================================================================
# Step 4: Backup Current MySQL (Optional but Recommended)
# ============================================================================

Write-Step "`n💾 Step 4: Backup current MySQL (RECOMMENDED)..."

$doBackup = Read-Host "Create backup of current MySQL? (y/n) [RECOMMENDED: y]"

if ($doBackup -eq "y") {
    $backupPath = "$laragonPath\backup"
    
    if (-not (Test-Path $backupPath)) {
        New-Item -ItemType Directory -Path $backupPath -Force | Out-Null
    }
    
    if ($currentMysql) {
        $backupName = "$($currentMysql.Name)-backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
        $backupFullPath = "$backupPath\$backupName"
        
        Write-Info "📦 Backing up MySQL installation..."
        Write-Info "📁 From: $mysqlBinPath\$($currentMysql.Name)"
        Write-Info "📁 To: $backupFullPath"
        
        try {
            Copy-Item "$mysqlBinPath\$($currentMysql.Name)" -Destination $backupFullPath -Recurse -Force
            Write-Success "✅ MySQL installation backed up"
        } catch {
            Write-Warning "⚠️  Backup failed: $_"
            Write-Warning "Continuing anyway, but be careful!"
        }
    }
    
    # Backup data directory
    $dataPath = "$laragonPath\data\mysql"
    if (Test-Path $dataPath) {
        $dataBackupName = "mysql-data-backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
        $dataBackupFullPath = "$backupPath\$dataBackupName"
        
        Write-Info "📦 Backing up MySQL data..."
        Write-Info "📁 From: $dataPath"
        Write-Info "📁 To: $dataBackupFullPath"
        
        try {
            Copy-Item $dataPath -Destination $dataBackupFullPath -Recurse -Force
            Write-Success "✅ MySQL data backed up"
        } catch {
            Write-Warning "⚠️  Data backup failed: $_"
            Write-Warning "Continuing anyway, but be extra careful!"
        }
    }
} else {
    Write-Warning "⚠️  Skipping backup. Make sure you have your own backup!"
}

# ============================================================================
# Step 5: Install MySQL 9.1.0
# ============================================================================

Write-Step "`n🚀 Step 5: Installing MySQL 9.1.0 to Laragon..."

$targetPath = "$mysqlBinPath\$mysqlFileName"

Write-Info "📁 Installing to: $targetPath"
Write-Info "⏳ This may take 2-3 minutes..."

try {
    Copy-Item "$extractPath\$($extractedMysql.Name)" -Destination $targetPath -Recurse -Force
    Write-Success "✅ MySQL 9.1.0 installed successfully"
} catch {
    Write-Error "❌ Installation failed: $_"
    Write-Info "`n🛠️  Manual Installation Instructions:"
    Write-Info "1. Copy folder: $extractPath\$($extractedMysql.Name)"
    Write-Info "2. Paste to: $mysqlBinPath\"
    Write-Info "3. Rename to: $mysqlFileName"
    exit 1
}

# Verify installation
if (-not (Test-Path "$targetPath\bin\mysql.exe")) {
    Write-Error "❌ Installation verification failed. mysql.exe not found."
    exit 1
}
Write-Success "✅ Installation verified"

# ============================================================================
# Step 6: Copy Configuration
# ============================================================================

Write-Step "`n⚙️  Step 6: Configuring MySQL 9.1.0..."

# Copy my.ini from old version if exists
$configCopied = $false
if ($currentMysql -and (Test-Path "$mysqlBinPath\$($currentMysql.Name)\my.ini")) {
    Write-Info "📋 Copying my.ini from: $($currentMysql.Name)"
    try {
        Copy-Item "$mysqlBinPath\$($currentMysql.Name)\my.ini" -Destination "$targetPath\my.ini" -Force
        Write-Success "✅ Configuration copied from old version"
        $configCopied = $true
    } catch {
        Write-Warning "⚠️  Could not copy configuration: $_"
    }
}

# Create default configuration if not copied
if (-not $configCopied) {
    Write-Info "📋 Creating default my.ini configuration..."
    
    $myIniContent = @"
[mysqld]
port=3306
basedir=$($targetPath.Replace('\', '/'))
datadir=$($laragonPath.Replace('\', '/'))/data/mysql
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
max_connections=200
max_allowed_packet=64M
innodb_buffer_pool_size=512M
skip-log-bin
sql_mode=STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION
default_authentication_plugin=caching_sha2_password

[mysql]
default-character-set=utf8mb4

[client]
port=3306
default-character-set=utf8mb4
"@
    
    try {
        Set-Content -Path "$targetPath\my.ini" -Value $myIniContent -Force
        Write-Success "✅ Default configuration created"
    } catch {
        Write-Warning "⚠️  Could not create configuration: $_"
        Write-Info "You may need to create my.ini manually later."
    }
}

# ============================================================================
# Step 7: Cleanup
# ============================================================================

Write-Step "`n🧹 Step 7: Cleaning up temporary files..."

try {
    Remove-Item $tempDir -Recurse -Force
    Write-Success "✅ Temporary files cleaned"
} catch {
    Write-Warning "⚠️  Could not clean temporary files: $_"
    Write-Info "You can manually delete: $tempDir"
}

# ============================================================================
# Step 8: Final Instructions
# ============================================================================

Write-Success "`n=========================================="
Write-Success "🎉 MySQL 9.1.0 Installation Complete!"
Write-Success "=========================================="

Write-Info "`n📋 NEXT STEPS (IMPORTANT):"
Write-Info ""
Write-Info "1. 🚀 Start Laragon:"
Write-Info "   - Open Laragon application"
Write-Info "   - Click 'Start All' or start services"
Write-Info ""
Write-Info "2. 🔄 Switch MySQL Version:"
Write-Info "   - Right-click Laragon icon in system tray"
Write-Info "   - Go to: MySQL → Version"
Write-Info "   - Select: mysql-$mysqlVersion-winx64"
Write-Info "   - Laragon will restart automatically"
Write-Info ""
Write-Info "3. ✅ Verify Installation:"
Write-Info "   - Open: http://localhost/phpmyadmin"
Write-Info "   - Check MySQL version (should show 9.1.0)"
Write-Info "   - Test database connections"
Write-Info ""
Write-Info "4. 🧪 Test with Command Line:"
Write-Info "   & `"$targetPath\bin\mysql.exe`" --version"
Write-Info ""

if ($doBackup -eq "y") {
    Write-Info "💾 Backup Locations:"
    if ($currentMysql) {
        Write-Info "   MySQL: $backupPath\$backupName"
    }
    Write-Info "   Data: $backupPath\$dataBackupName"
    Write-Info ""
}

Write-Warning "⚠️  IMPORTANT NOTES:"
Write-Warning "   - Test all databases after switching"
Write-Warning "   - Keep backups until everything is confirmed working"
Write-Warning "   - If issues occur, you can rollback to old version"
Write-Warning ""

Write-Info "🔄 Rollback Instructions (if needed):"
Write-Info "   1. Laragon → MySQL → Version → Select old version"
Write-Info "   2. Restore data from backup if needed"
Write-Info ""

Write-Info "🆘 Troubleshooting:"
Write-Info "   - Error logs: $laragonPath\data\mysql\mysql_error.log"
Write-Info "   - Laragon logs: $laragonPath\logs\"
Write-Info "   - MySQL docs: https://dev.mysql.com/doc/"
Write-Info ""

Write-Success "✅ Installation script completed successfully!"
Write-Success "MySQL 9.1.0 is ready to use with PHP 8.5!"

Write-Info "`nPress any key to exit..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")