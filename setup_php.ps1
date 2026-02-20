# PHP 8.2 Download and Setup Script for E-Template
# Run this script to automatically download and configure portable PHP

param(
    [string]$PhpVersion = "8.2.27",
    [string]$OutputDir = ".\php"
)

$ErrorActionPreference = "Stop"

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   PHP 8.2 Portable Setup Script" -ForegroundColor Cyan  
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# PHP download URL (VS16 x64 Thread Safe)
$phpZipName = "php-$PhpVersion-Win32-vs16-x64.zip"
$phpDownloadUrl = "https://windows.php.net/downloads/releases/$phpZipName"
$tempZip = "$env:TEMP\$phpZipName"

Write-Host "[1/4] Downloading PHP $PhpVersion..." -ForegroundColor Yellow
Write-Host "  URL: $phpDownloadUrl" -ForegroundColor Gray

try {
    # Use TLS 1.2
    [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
    
    # Download with progress
    $webClient = New-Object System.Net.WebClient
    $webClient.DownloadFile($phpDownloadUrl, $tempZip)
    Write-Host "  Download complete!" -ForegroundColor Green
} catch {
    Write-Host ""
    Write-Host "ERROR: Failed to download PHP!" -ForegroundColor Red
    Write-Host "Please download manually from: https://windows.php.net/download" -ForegroundColor Yellow
    Write-Host "Get: PHP 8.2.x VS16 x64 Thread Safe (Zip)" -ForegroundColor Yellow
    Write-Host ""
    exit 1
}

Write-Host "[2/4] Extracting PHP..." -ForegroundColor Yellow
if (Test-Path $OutputDir) {
    Remove-Item $OutputDir -Recurse -Force
}
New-Item -ItemType Directory -Path $OutputDir -Force | Out-Null

Expand-Archive -Path $tempZip -DestinationPath $OutputDir -Force
Write-Host "  Extracted to: $OutputDir" -ForegroundColor Green

Write-Host "[3/4] Configuring PHP..." -ForegroundColor Yellow

# Copy and customize php.ini
if (Test-Path "php.ini.portable") {
    Copy-Item -Path "php.ini.portable" -Destination "$OutputDir\php.ini" -Force
    Write-Host "  php.ini configured from template" -ForegroundColor Green
} else {
    # Create php.ini from development template if no portable template exists
    if (Test-Path "$OutputDir\php.ini-development") {
        Copy-Item -Path "$OutputDir\php.ini-development" -Destination "$OutputDir\php.ini" -Force
        
        # Enable required extensions
        $phpIni = Get-Content "$OutputDir\php.ini" -Raw
        $phpIni = $phpIni -replace ';extension=pdo_sqlite', 'extension=pdo_sqlite'
        $phpIni = $phpIni -replace ';extension=sqlite3', 'extension=sqlite3'
        $phpIni = $phpIni -replace ';extension=mbstring', 'extension=mbstring'
        $phpIni = $phpIni -replace ';extension=fileinfo', 'extension=fileinfo'
        $phpIni = $phpIni -replace ';extension=openssl', 'extension=openssl'
        $phpIni = $phpIni -replace ';extension=zip', 'extension=zip'
        $phpIni = $phpIni -replace ';extension=gd', 'extension=gd'
        $phpIni = $phpIni -replace ';extension=curl', 'extension=curl'
        $phpIni | Set-Content "$OutputDir\php.ini"
        Write-Host "  php.ini configured with required extensions" -ForegroundColor Green
    }
}

Write-Host "[4/4] Verifying installation..." -ForegroundColor Yellow

# Test PHP
$phpExe = "$OutputDir\php.exe"
if (Test-Path $phpExe) {
    $version = & $phpExe -v 2>&1 | Select-Object -First 1
    Write-Host "  $version" -ForegroundColor Green
    
    # Check extensions
    Write-Host ""
    Write-Host "  Loaded extensions:" -ForegroundColor Gray
    $extensions = @("pdo_sqlite", "sqlite3", "mbstring", "fileinfo", "openssl", "zip")
    foreach ($ext in $extensions) {
        $loaded = & $phpExe -m 2>&1 | Select-String -Pattern "^$ext$" -Quiet
        if ($loaded) {
            Write-Host "    [OK] $ext" -ForegroundColor Green
        } else {
            Write-Host "    [!!] $ext (not loaded)" -ForegroundColor Yellow
        }
    }
} else {
    Write-Host "  ERROR: php.exe not found!" -ForegroundColor Red
    exit 1
}

# Cleanup
Remove-Item $tempZip -Force -ErrorAction SilentlyContinue

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "   PHP Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "PHP runtime is ready at: $OutputDir" -ForegroundColor White
Write-Host "You can now run: .\build_portable.ps1" -ForegroundColor Cyan
Write-Host ""
