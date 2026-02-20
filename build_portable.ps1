# E-Template Portable Build Script
# Run this script from the project root directory
#
# Fixes Applied:
# - RF-001 to RF-005: Proper build order to prevent dev-package autoload errors
# - ISSUE-001: Remove artisan from runtime distribution
# - ISSUE-002: Ensure SQLite path resolution is consistent
# - ISSUE-003: Use classmap-authoritative for portable autoloading
# - ISSUE-004: Backup .env before overwriting

param(
    [string]$OutputDir = ".\dist\E-Template-Portable",
    [switch]$SkipAssets,
    [switch]$SkipDatabase
)

$ErrorActionPreference = "Stop"

Write-Host ""
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "   E-Template Portable Build Script (Hardened)" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

# ============================================================
# Pre-flight checks
# ============================================================
if (-not (Test-Path "artisan")) {
    Write-Host "ERROR: This script must be run from the Laravel project root!" -ForegroundColor Red
    exit 1
}

if (-not (Test-Path ".env.production")) {
    Write-Host "ERROR: .env.production not found!" -ForegroundColor Red
    exit 1
}

# ============================================================
# ISSUE-004: Backup .env before overwriting
# ============================================================
Write-Host "[1/8] Backing up development environment (ISSUE-004)..." -ForegroundColor Yellow
if (-not (Test-Path ".env.backup")) {
    if (Test-Path ".env") {
        Copy-Item -Path ".env" -Destination ".env.backup" -Force
        Write-Host "  Created .env.backup" -ForegroundColor Gray
    }
} else {
    Write-Host "  .env.backup already exists (preserved)" -ForegroundColor Gray
}

# ============================================================
# STEP 2: Build frontend assets (before environment changes)
# ============================================================
if (-not $SkipAssets) {
    Write-Host "[2/8] Building frontend assets..." -ForegroundColor Yellow
    npm run build
    if ($LASTEXITCODE -ne 0) {
        Write-Host "ERROR: npm build failed!" -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "[2/8] Skipping asset build..." -ForegroundColor Gray
}

# ============================================================
# RF-001: Apply production environment BEFORE Laravel boots
# ============================================================
Write-Host "[3/8] Applying production environment (RF-001)..." -ForegroundColor Yellow
Copy-Item -Path ".env.production" -Destination ".env" -Force
Write-Host "  .env.production copied to .env" -ForegroundColor Gray

# ============================================================
# RF-003: Clear Laravel bootstrap cache BEFORE composer install
# This MUST happen before --no-dev to prevent autoloader crashes
# ============================================================
Write-Host "[4/8] Clearing bootstrap cache (RF-003)..." -ForegroundColor Yellow
$cacheFiles = @(
    "bootstrap\cache\packages.php",
    "bootstrap\cache\services.php",
    "bootstrap\cache\config.php",
    "bootstrap\cache\routes-v7.php",
    "bootstrap\cache\events.php"
)
foreach ($file in $cacheFiles) {
    if (Test-Path $file) {
        Remove-Item $file -Force
        Write-Host "  Deleted $file" -ForegroundColor Gray
    }
}

# ============================================================
# RF-002 + ISSUE-003: Install production dependencies
# Use --no-scripts to prevent Laravel post-install scripts from crashing
# Use --ignore-platform-reqs because host (XAMPP) might lack extensions 
# that valid portable PHP has (e.g. gd, zip)
# ============================================================
Write-Host "[5/8] Installing production dependencies (RF-002, ISSUE-003)..." -ForegroundColor Yellow
composer install --no-dev --classmap-authoritative --no-scripts --no-interaction --ignore-platform-reqs
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: composer install failed!" -ForegroundColor Red
    exit 1
}

# ============================================================
# RF-004: Regenerate package discovery WITHOUT dev packages
# ============================================================
Write-Host "[6/8] Regenerating package discovery (RF-004)..." -ForegroundColor Yellow
php artisan package:discover --ansi
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: package:discover failed!" -ForegroundColor Red
    exit 1
}

# ============================================================
# RF-005: Clear all compiled/optimized caches
# ============================================================
Write-Host "[7/8] Clearing compiled caches (RF-005)..." -ForegroundColor Yellow
php artisan optimize:clear --ansi

# ============================================================
# ISSUE-002: Prepare database with consistent path resolution
# ============================================================
if (-not $SkipDatabase) {
    Write-Host "  Preparing SQLite database (ISSUE-002)..." -ForegroundColor Gray
    
    # Ensure database file exists with proper relative path
    $dbPath = "database\database.sqlite"
    if (-not (Test-Path $dbPath)) {
        New-Item -ItemType File -Path $dbPath -Force | Out-Null
        Write-Host "    Created $dbPath" -ForegroundColor Gray
    }
    
    # Run migrations
    php artisan migrate --force
    if ($LASTEXITCODE -ne 0) {
        Write-Host "ERROR: Migration failed!" -ForegroundColor Red
        exit 1
    }
}

# ============================================================
# STEP 8: Create distribution package
# ============================================================
Write-Host "[8/8] Creating distribution package..." -ForegroundColor Yellow

# Remove existing output directory
if (Test-Path $OutputDir) { 
    Remove-Item $OutputDir -Recurse -Force 
}
New-Item -ItemType Directory -Path $OutputDir -Force | Out-Null

# ============================================================
# ISSUE-001: Files to copy (artisan EXCLUDED from runtime)
# ============================================================
$itemsToCopy = @(
    "app",
    "bootstrap",
    "config", 
    "database",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor",
    ".env",
    # "artisan" - EXCLUDED: No CLI execution at runtime (ISSUE-001)
    "composer.json",
    "start.bat"
)

foreach ($item in $itemsToCopy) {
    if (Test-Path $item) {
        Write-Host "  Copying $item..." -ForegroundColor Gray
        Copy-Item -Path $item -Destination $OutputDir -Recurse -Force
    }
}

# Copy PHP runtime
if (Test-Path "php") {
    Write-Host "  Copying PHP runtime..." -ForegroundColor Gray
    Copy-Item -Path "php" -Destination $OutputDir -Recurse -Force
} else {
    Write-Host ""
    Write-Host "WARNING: PHP runtime folder not found!" -ForegroundColor Yellow
    Write-Host "Run setup_php.ps1 first or manually add PHP to: $OutputDir\php" -ForegroundColor Yellow
}

# ============================================================
# Post-copy cleanup and hardening
# ============================================================
Write-Host "  Hardening distribution..." -ForegroundColor Gray

# Remove development/build artifacts from dist
$cleanupPatterns = @(
    "$OutputDir\storage\logs\*.log",
    "$OutputDir\storage\framework\cache\data\*",
    "$OutputDir\storage\framework\sessions\*",
    "$OutputDir\storage\framework\views\*.php",
    "$OutputDir\bootstrap\cache\*.php"  # Clear bootstrap cache in dist too
)
foreach ($pattern in $cleanupPatterns) {
    Remove-Item -Path $pattern -Force -Recurse -ErrorAction SilentlyContinue
}

# Ensure required directories exist in dist
$requiredDirs = @(
    "$OutputDir\storage\app\public",
    "$OutputDir\storage\framework\cache\data",
    "$OutputDir\storage\framework\sessions",
    "$OutputDir\storage\framework\views",
    "$OutputDir\storage\logs",
    "$OutputDir\bootstrap\cache"
)
foreach ($dir in $requiredDirs) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
}

# Ensure public/storage points to storage/app/public for uploaded files
Write-Host "  Configuring public storage link..." -ForegroundColor Gray
$publicStoragePath = Join-Path $OutputDir "public\storage"
$storagePublicPath = Join-Path $OutputDir "storage\app\public"

if (Test-Path $publicStoragePath) {
    Remove-Item -Path $publicStoragePath -Recurse -Force -ErrorAction SilentlyContinue
}

try {
    New-Item -ItemType Junction -Path $publicStoragePath -Target $storagePublicPath -Force | Out-Null
    Write-Host "    public\\storage -> storage\\app\\public" -ForegroundColor Gray
} catch {
    Write-Host "WARNING: Failed to create public\\storage junction: $($_.Exception.Message)" -ForegroundColor Yellow
}

# Create .gitkeep placeholder files
foreach ($dir in $requiredDirs) {
    $gitkeep = Join-Path $dir ".gitkeep"
    if (-not (Test-Path $gitkeep)) {
        New-Item -ItemType File -Path $gitkeep -Force | Out-Null
    }
}

# ============================================================
# Verify distribution integrity
# ============================================================
Write-Host "  Verifying distribution..." -ForegroundColor Gray
$errors = @()

# ISSUE-001: Verify artisan is NOT in dist
if (Test-Path "$OutputDir\artisan") {
    $errors += "artisan found in dist (should be excluded)"
}

# Verify PHP runtime
if (-not (Test-Path "$OutputDir\php\php.exe")) {
    $errors += "PHP runtime not found in dist"
}

# Verify database
if (-not (Test-Path "$OutputDir\database\database.sqlite")) {
    $errors += "SQLite database not found in dist"
}

# Verify start.bat
if (-not (Test-Path "$OutputDir\start.bat")) {
    $errors += "start.bat not found in dist"
}

# Verify public storage link/folder for uploaded draft files
if (-not (Test-Path "$OutputDir\public\storage")) {
    $errors += "public\\storage not found in dist (uploaded files URL may fail)"
}

if ($errors.Count -gt 0) {
    Write-Host ""
    Write-Host "WARNINGS:" -ForegroundColor Yellow
    foreach ($err in $errors) {
        Write-Host "  - $err" -ForegroundColor Yellow
    }
}

# ============================================================
# Done
# ============================================================
Write-Host ""
Write-Host "================================================" -ForegroundColor Green
Write-Host "   Build Complete!" -ForegroundColor Green
Write-Host "================================================" -ForegroundColor Green
Write-Host ""
Write-Host "Output: $OutputDir" -ForegroundColor White
Write-Host ""
Write-Host "To test:" -ForegroundColor Cyan
Write-Host "  cd `"$OutputDir`"" -ForegroundColor White
Write-Host "  .\start.bat" -ForegroundColor White
Write-Host ""
Write-Host "To restore development environment:" -ForegroundColor Yellow
Write-Host "  Copy-Item .env.backup .env -Force" -ForegroundColor White
Write-Host "  composer install" -ForegroundColor White
Write-Host ""
