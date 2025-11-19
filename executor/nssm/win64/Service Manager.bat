@echo off
setlocal enabledelayedexpansion

REM Path nssm.exe full
::set NSSM=C:\laragon\www\siakad\executor\nssm\win64\nssm.exe
set "BASEDIR=%~dp0"
set "NSSM=C:\laragon\www\siakad\executor\nssm\win64\nssm.exe"


:MENU
cls
echo =================================
echo        SERVICE MANAGER
echo =================================
echo [1] Stop ^& hapus myNodeserver
echo [2] Stop ^& hapus LaravelSchedule
echo [3] Stop ^& hapus NgrokService
echo [4] Stop ^& hapus Semua service
echo [5] Setup myNodeserver
echo [6] Setup LaravelSchedule
echo [7] Setup NgrokService
echo [8] Cek status semua service
echo [9] Stop myNodeserver (tanpa hapus)
echo [10] Stop LaravelSchedule (tanpa hapus)
echo [11] Stop NgrokService (tanpa hapus)
echo [12] Start myNodeserver
echo [13] Start LaravelSchedule
echo [14] Start NgrokService
echo [15] Restart All Service
echo [16] BackUp Database
echo [17] Setup Cleaner Temp ( TempCleaner )
echo [nssm] Cek All Service NSSM
echo [stp] Setup All Service ( NgrokService, LaravelSchedule, myNodeserver, Temp )
echo [delx] Del Service
echo [0] Keluar
echo =================================
set /p choice="Pilih opsi: "

if "%choice%"=="1" goto NODE
if "%choice%"=="2" goto LARAVEL
if "%choice%"=="3" goto NGROK
if "%choice%"=="4" goto ALL
if "%choice%"=="5" goto SETUP_NODE
if "%choice%"=="6" goto SETUP_LARAVEL
if "%choice%"=="7" goto SETUP_NGROK
if "%choice%"=="8" goto STATUS
if "%choice%"=="9" goto STOP_NODE
if "%choice%"=="10" goto STOP_LARAVEL
if "%choice%"=="11" goto STOP_NGROK
if "%choice%"=="12" goto START_NODE
if "%choice%"=="13" goto START_LARAVEL
if "%choice%"=="14" goto START_NGROK
if "%choice%"=="15" goto RESTART_SERVICE
if "%choice%"=="16" goto BACKUP_DATABASE
if "%choice%"=="17" goto SETUP_CLEANER_TEMP
if "%choice%"=="nssm" goto CEK_SERVICE_NSSM
if "%choice%"=="stp" goto SETUP_STP
if "%choice%"=="delx" goto DEL_SERVICE
if "%choice%"=="0" goto EXIT

goto MENU

:NODE
echo Menghentikan ^& menghapus myNodeserver...
sc stop myNodeserver
sc delete myNodeserver
pause
goto MENU

:LARAVEL
echo Menghentikan ^& menghapus LaravelSchedule...
sc stop LaravelSchedule
sc delete LaravelSchedule
pause
goto MENU

:NGROK
echo Menghentikan ^& menghapus NgrokService...
sc stop NgrokService
sc delete NgrokService
pause
goto MENU

:ALL
echo Menghentikan ^& menghapus SEMUA service...
sc stop myNodeserver
sc delete myNodeserver
sc stop LaravelSchedule
sc delete LaravelSchedule
sc stop NgrokService
sc delete NgrokService
pause
goto MENU

:STOP_NODE
echo Hanya menghentikan myNodeserver...
sc stop myNodeserver
pause
goto MENU

:STOP_LARAVEL
echo Hanya menghentikan LaravelSchedule...
sc stop LaravelSchedule
pause
goto MENU

:STOP_NGROK
echo Hanya menghentikan NgrokService...
sc stop NgrokService
pause
goto MENU

:START_NODE
echo Menjalankan myNodeserver...
sc start myNodeserver
sc query myNodeserver
pause
goto MENU

:START_LARAVEL
echo Menjalankan LaravelSchedule...
sc start LaravelSchedule
sc query LaravelSchedule
pause
goto MENU

:START_NGROK
echo Menjalankan NgrokService...
sc start NgrokService
sc query NgrokService
pause
goto MENU

:SETUP_NODE
echo Membuat ulang service myNodeserver...
sc stop myNodeserver
sc delete myNodeserver

for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

nssm install myNodeserver "C:\Program Files\nodejs\node.exe" "C:\laragon\www\siakad\whatsapp\server.js"
nssm set myNodeserver AppDirectory "C:\laragon\www\siakad\whatsapp"
nssm set myNodeserver AppExit Default Restart
nssm set myNodeserver AppThrottle 5000
nssm set myNodeserver AppStopMethodSkip 6

sc start myNodeserver
sc query myNodeserver
pause
goto MENU

:SETUP_LARAVEL
echo Membuat ulang service LaravelSchedule...
sc stop LaravelSchedule
sc delete LaravelSchedule

"%NSSM%" install LaravelSchedule "C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe" artisan schedule:work
"%NSSM%" set LaravelSchedule AppDirectory "C:\laragon\www\siakad"
"%NSSM%" set LaravelSchedule AppExit Default Restart

sc start LaravelSchedule
sc query LaravelSchedule
pause
goto MENU

:SETUP_NGROK
echo Membuat ulang service NgrokService...
sc stop NgrokService
sc delete NgrokService

cd /d C:\laragon\www\siakad\executor\nssm\win64
"%NSSM%" install NgrokService "C:\laragon\www\siakad\executor\ngrok\ngrok_akses.exe"
"%NSSM%" set NgrokService AppDirectory "C:\laragon\www\siakad\executor\ngrok"
"%NSSM%" set NgrokService AppExit Default Restart

sc start NgrokService
sc query NgrokService
pause
goto MENU

:STATUS
cls
cd /d C:\laragon\www\siakad\executor\nssm\win64
echo =======================================
echo Cek Services
echo =======================================
sc query myNodeserver
sc query LaravelSchedule
sc query NgrokService
timeout /t 10 >nul
cls
echo =======================================
echo Curl Cek Server JS
echo =======================================
echo ---------------------------------
echo Cek HTTP localhost:3000
curl -s -o nul -w "HTTP Code=%%{http_code}" http://localhost:3000
echo.
timeout /t 10 >nul
cls
echo =======================================
echo Command Server Aktif
echo =======================================
echo Menjalankan artisan start:ServerAktif...
CD /d C:\laragon\www\siakad
php artisan start:ServerAktif

echo Mengecek endpoint /status...
for /f %%i in ('curl -s -o nul -w "%%{http_code}" http://localhost:3000/status 2^>nul') do set status=%%i
timeout /t 10 >nul
if "%status%"=="200" (
    echo Server Aktif dan siap digunakan
) else (
    echo Server tidak merespon, status=%status%
)
pause
goto MENU

:RESTART_SERVICE
echo Mengecek status semua service...
cd /d C:\laragon\www\siakad\executor\nssm\win64
cls
echo =======================================
echo Restart myNodeserver
echo =======================================
sc stop myNodeserver
timeout /t 5 >nul
sc start myNodeserver
timeout /t 5 >nul
sc query myNodeserver
timeout /t 5 >nul
echo Proses restart myNodeserver selesai
timeout /t 5 >nul
cls
echo =======================================
echo Restart LaravelSchedule
echo =======================================
sc stop LaravelSchedule
timeout /t 5 >nul
sc start LaravelSchedule
timeout /t 5 >nul
sc query LaravelSchedule
timeout /t 5 >nul
echo Proses restart LaravelSchedule selesai
timeout /t 5 >nul
cls
echo =======================================
echo Restart NgrokService
echo =======================================
sc stop NgrokService
timeout /t 5 >nul
sc start NgrokService
timeout /t 5 >nul
sc query NgrokService
timeout /t 5 >nul
echo Proses restart NgrokService selesai
timeout /t 5 >nul
pause
goto MENU

:BACKUP_DATABASE
cls
echo ================================
echo :: Backup Database MySQL
echo ================================

:BACKUP_DATABASE
cd /d C:\laragon\bin\mysql\mysql-8.3.0-winx64\bin

REM Ambil tanggal sekarang (YYYYMMDD)
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value ^| find "="') do set datetime=%%I
set today=%datetime:~0,8%

REM Nama database yang mau dibackup
set dbname=siakad

REM Folder tujuan backup
set backup_dir=C:\laragon\www\siakad\executor\nssm\win64\db_backup

if not exist "%backup_dir%" mkdir "%backup_dir%"

echo Backup database "%dbname%"...
mysqldump -u root -p"" -h localhost %dbname% > "%backup_dir%\%dbname%_%today%.sql"

if %errorlevel%==0 (
    echo Backup selesai: %backup_dir%\%dbname%_%today%.sql
) else (
    echo Backup gagal!
)
timeout /t 3 >nul
goto MENU
:SETUP_CLEANER_TEMP
echo Membuat ulang service TempCleaner...
sc stop TempCleaner >nul 2>&1
sc delete TempCleaner >nul 2>&1

cd /d C:\laragon\www\siakad\executor\nssm\win64
REM "%NSSM%" install LaravelSchedule C:\Windows\System32\cmd.exe "/c C:\laragon\www\siakad\executor\siakad\schedule.bat"
:: "%NSSM%" install TempCleaner C:\Windows\System32\cmd.exe "/c C:\laragon\www\siakad\executor\pc\TempCleaner.bat"
"%NSSM%" install LaravelSchedule "C:\laragon\www\siakad\executor\siakad\schedule.bat"

REM "%NSSM%" install TempCleaner "C:\laragon\www\siakad\executor\ngrok\ngrok_akses.exe"
REM "%NSSM%" install TempCleaner "C:\laragon\www\siakad\executor\pc\TempCleaner.exe"
"%NSSM%" set TempCleaner AppDirectory "C:\laragon\www\siakad\executor\pc"
"%NSSM%" set TempCleaner AppExit Default Restart
"%NSSM%" set TempCleaner AppPauseMethod None

sc start TempCleaner
sc query TempCleaner

timeout /t 3 >nul
goto MENU

:CEK_SERVICE_NSSM
cls
echo ============================================
echo :: Daftar Service NSSM + File yang Dijalankan
echo ============================================

rem loop semua service, ambil token nama service setelah ':'
for /f "tokens=2 delims=:" %%a in ('sc query state^= all ^| findstr "SERVICE_NAME"') do (
    call :checksvc "%%a"
)

echo.
echo Tekan tombol apapun untuk kembali ke MENU...
pause >nul
goto MENU


:checksvc
rem --- subroutine menerima 1 argumen: nama service (mungkin dengan spasi)
rem %~1 = nama service (di-quote jika ada spasi)
set "svc=%~1"

rem trim leading spaces
for /f "tokens=* delims= " %%T in ("%svc%") do set "svc=%%T"

rem ambil BINARY_PATH_NAME
set "binpath="
for /f "tokens=2*" %%b in ('sc qc "%svc%" ^| findstr /i "BINARY_PATH_NAME"') do set "binpath=%%c"

rem jika tidak ada binpath -> kembali
if not defined binpath exit /b

rem cek apakah binpath mengandung "%NSSM%".exe
echo %binpath% | findstr /i ""%NSSM%".exe" >nul
if errorlevel 1 exit /b

rem tampilkan info dasar
echo Service: %svc%
echo Path NSSM : %binpath%

rem ambil Application
set "app="
for /f "tokens=2*" %%x in ('reg query "HKLM\SYSTEM\CurrentControlSet\Services\%svc%\Parameters" /v Application 2^>nul ^| findstr /i "Application"') do set "app=%%y"
if defined app (echo    File Run  : %app%) else echo    File Run  : (tidak ada)

rem ambil AppDirectory
set "dir="
for /f "tokens=2*" %%x in ('reg query "HKLM\SYSTEM\CurrentControlSet\Services\%svc%\Parameters" /v AppDirectory 2^>nul ^| findstr /i "AppDirectory"') do set "dir=%%y"
if defined dir (echo    Directory : %dir%) else echo    Directory : (tidak ada)

rem ambil AppParameters
set "params="
for /f "tokens=2*" %%x in ('reg query "HKLM\SYSTEM\CurrentControlSet\Services\%svc%\Parameters" /v AppParameters 2^>nul ^| findstr /i "AppParameters"') do set "params=%%y"
if defined params (echo    Params    : %params%) else echo    Params    : (tidak ada)

rem ambil status service (STATE)
set "status="
for /f "tokens=3*" %%s in ('sc query "%svc%" ^| findstr /i "STATE"') do set "status=%%t"
if defined status (echo    Status    : %status%) else echo    Status    : (tidak diketahui)

echo.
exit /b
:SETUP_STP
echo ======================================
echo :: SETUP SEMUA SERVICE
echo ======================================

call :SETUP_CLEANER_TEMP
call :SETUP_NGROK
call :SETUP_LARAVEL
call :SETUP_NODE

echo.
echo Semua setup selesai!
pause
goto MENU
:DEL_SERVICE
cls
echo ======================================
echo :: HAPUS SERVICE BERDASARKAN NAMA
echo ======================================
echo Ketik nama service yang ingin dihapus.
echo Contoh: TempCleaner
echo Ketik 0 untuk batal.
echo.

set /p svcname=Masukkan nama service: 

if "%svcname%"=="0" goto MENU
if "%svcname%"=="" (
    echo Nama service tidak boleh kosong!
    pause
    goto DEL_SERVICE
)

echo Menghapus service %svcname%...
sc stop "%svcname%" >nul 2>&1
sc delete "%svcname%" >nul 2>&1

echo Service %svcname% telah dihapus (jika ada).
pause
goto MENU



:EXIT
echo Keluar
