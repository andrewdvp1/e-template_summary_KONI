@echo off
setlocal enabledelayedexpansion

:: ============================================================
:: Konimex E-Template Launcher (Production-Grade, .exe-safe)
:: ============================================================
:: Rules followed:
:: - NO artisan calls at runtime (migrations = build time only)
:: - Kill by PID/port, not by process name
:: - Explicit PHPRC for php.ini location
:: - Proper error handling
:: ============================================================

title Konimex E-Template

:: Change to script directory (works in .bat and .exe)
cd /d "%~dp0"

echo.
echo =============================================
echo        Konimex E-Template Launcher
echo =============================================
echo.

:: -----------------------------------------------------------
:: STEP 1: Verify PHP runtime exists
:: -----------------------------------------------------------
if not exist "php\php.exe" (
    echo [ERROR] PHP runtime not found!
    echo         Expected: %~dp0php\php.exe
    echo.
    pause
    exit /b 1
)

:: -----------------------------------------------------------
:: STEP 2: Set PHPRC so PHP finds the correct php.ini
:: -----------------------------------------------------------
set "PHPRC=%~dp0php"

:: -----------------------------------------------------------
:: STEP 3: Define port and check availability
:: -----------------------------------------------------------
set PORT=8000
set URL=http://127.0.0.1:%PORT%

:: Check if port is already in use
netstat -ano 2>nul | findstr ":%PORT% " | findstr "LISTENING" >nul
if %ERRORLEVEL% equ 0 (
    echo [ERROR] Port %PORT% is already in use!
    echo         Please close the application using that port.
    echo.
    pause
    exit /b 1
)

:: -----------------------------------------------------------
:: STEP 4: Verify database exists (but DO NOT migrate!)
:: -----------------------------------------------------------
if not exist "database\database.sqlite" (
    echo [ERROR] Database not found!
    echo         Expected: %~dp0database\database.sqlite
    echo         The database should be created during build, not at runtime.
    echo.
    pause
    exit /b 1
)

:: -----------------------------------------------------------
:: STEP 5: Start PHP server using cmd /c for .exe compatibility
:: -----------------------------------------------------------
echo Starting server on port %PORT%...

:: Start PHP in a new hidden cmd process
:: This ensures the server survives even if wrapper closes briefly
start "" /B cmd /c "php\php.exe -S 127.0.0.1:%PORT% -t public >nul 2>&1"

:: Wait for server to start (poll instead of fixed timeout)
set RETRIES=10
:wait_loop
if %RETRIES% leq 0 (
    echo [ERROR] Server failed to start!
    pause
    exit /b 1
)

:: Check if server is listening
netstat -ano 2>nul | findstr ":%PORT% " | findstr "LISTENING" >nul
if %ERRORLEVEL% neq 0 (
    timeout /t 1 /nobreak >nul
    set /a RETRIES=%RETRIES%-1
    goto wait_loop
)

echo Server started successfully!
echo.

:: -----------------------------------------------------------
:: STEP 6: Open browser
:: -----------------------------------------------------------
start "" "%URL%"

:: -----------------------------------------------------------
:: STEP 7: Wait for user to stop
:: -----------------------------------------------------------
echo =============================================
echo  Server running at %URL%
echo =============================================
echo.
echo  Press any key to STOP the server...
echo.
pause >nul

:: -----------------------------------------------------------
:: STEP 8: Kill ONLY our PHP server (by port, not by name)
:: -----------------------------------------------------------
echo.
echo Stopping server...

:: Find PID of process listening on our port and kill it
for /f "tokens=5" %%p in ('netstat -ano 2^>nul ^| findstr ":%PORT% " ^| findstr "LISTENING"') do (
    taskkill /PID %%p /F >nul 2>&1
)

echo.
echo =============================================
echo    Server stopped successfully!
echo =============================================
timeout /t 2 >nul

endlocal
exit /b 0
