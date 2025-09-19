@echo off
setlocal enabledelayedexpansion
title Aplikasi Service Siakad Maintenance Menu
title Aplikasi Service Siakad - ATA DIGITAL
color 0A

echo ============================
echo     ATA DIGITAL SYSTEM
echo ============================
echo [x] Menyiapkan Data...
timeout /t 1 >nul
echo [x] Menyiapkan Menu dan Informasi...
timeout /t 1 >nul
echo [x] Generate Menu...

timeout /t 5 >nul
:menu
cls
color 0A
echo ====================================================^|
echo       WhatsApp Project Menu                         ^|
echo ====================================================^|
echo [wa-1] Hapus Semua Session ^& Cache
echo [wa-2] Hapus Session Tertentu
echo [wa-3] Hapus Cache
echo [wa-4] Hapus ^& Install Ulang Node Modules
echo [wa-5] Instal Obfuscator
echo [wa-6] Enscript Server.js
echo [wa-7] Backup Session ^& Cache
echo [wa-8] Restart Server
echo [wa-9] Clear Logs
echo( 
echo ====================================================^|
echo       Menu NSSM Service
echo ====================================================^|
echo [nssm-1] Setup service myNodeserver
echo [nssm-2] Setup service LaravelSchedule
echo [nssm-3] Setup service myNodeserver ^& LaravelSchedule
echo [nssm-4] Remove service myNodeserver
echo [nssm-5] Remove service LaravelSchedule
echo [nssm-6] Cek service myNodeserver ^& LaravelSchedule
echo [nssm-7] Start Service
echo [nssm-8] Restart Service
echo [nssm-9] Create SC
echo( 
echo ====================================================^|
echo       Menu MySql
echo ====================================================^|
echo [sql-1] Reinitialize MySQL
echo [sql-2] (Reserved)
echo 
echo ====================================================^|
echo       Menu PC
echo ====================================================^|
echo [pc-1] Restart
echo [pc-2] Shutdown
echo [pc-3] Clear Temp
echo [pc-4] Membersihkan Recycle Bin
echo( 
echo ====================================================^|
echo       Menu Git
echo ====================================================^|
echo [git-1] Clone Repo WhatsApp
::echo [git-x] 
echo( 
echo ====================================================^|
echo       Menu Instalasi Palikasi Server
echo ====================================================^|
echo [apk-1] Node.js
echo [apk-2] Composser
echo [apk-3] Imagick HDRI
echo [apk-4] Tabel Plus
echo [apk-5] UltraViewer
echo [apk-6] PCMobolity
::echo [git-x] 
echo( 
echo ====================================================^|
echo       Menu Open Services
echo ====================================================^|
echo [oser-1] Task Manager
echo [oser-2] Task Schedule
echo [oser-3] Service MSC
echo [oser-4] Remove Services
echo [oser-5] Create Task Schedule
echo [oser-6] NSSM
::echo [git-x] 
echo( 
echo 0. Keluar
echo( 
echo ====================================================^|
echo   Dibangun oleh ATA DIGITAL
echo   HP      : 0853-2986-0005
echo   Alamat  : Jl. Makensi Banjarharjo, Kab. Brebes
echo   website : -
echo ====================================================^|

set /p choice=Masukkan pilihan: 

if "%choice%"=="wa-1" goto delAll
if "%choice%"=="wa-2" goto delSession
if "%choice%"=="wa-3" goto delCache
if "%choice%"=="wa-4" goto reinstallModules
if "%choice%"=="wa-5" goto installObfuscator
if "%choice%"=="wa-6" goto encryptServer
if "%choice%"=="wa-7" goto backup
if "%choice%"=="wa-8" goto restartServer
if "%choice%"=="wa-9" goto clearLogs
if "%choice%"=="nssm-1" goto setupMyNode
if "%choice%"=="nssm-2" goto setupLaravelSchedule
if "%choice%"=="nssm-3" goto setupBothServices
if "%choice%"=="nssm-4" goto removeMyNode
if "%choice%"=="nssm-5" goto removeLaravelSchedule
if "%choice%"=="nssm-6" goto checkServices
if "%choice%"=="nssm-7" goto startServices
if "%choice%"=="nssm-8" goto restartServices
if "%choice%"=="nssm-9" goto nssmCreateSC
if "%choice%"=="sql-1" goto reinitMySQL
if "%choice%"=="20" goto reserved
if "%choice%"=="git-1" goto cloneRepo
if "%choice%"=="apk-1" goto ApkNodeJs
if "%choice%"=="apk-2" goto ApkComposser
if "%choice%"=="apk-3" goto ApkImagickHDRI
if "%choice%"=="apk-4" goto ApkTablePlus
if "%choice%"=="apk-5" goto ApkUltraViewer
if "%choice%"=="apk-6" goto ApkPCMobolity
if "%choice%"=="pc-1" goto PCrestart
if "%choice%"=="pc-2" goto PCShutdown
if "%choice%"=="pc-3" goto PCClearTemp
if "%choice%"=="pc-4" goto PCClearRecycleBin
if "%choice%"=="oser-1" goto OserTskm
if "%choice%"=="oser-2" goto OserTskSchedule
if "%choice%"=="oser-3" goto OserServicesMsc
if "%choice%"=="oser-4" goto RemoveService
if "%choice%"=="oser-5" goto OserCreateTskSchedule
if "%choice%"=="0" exit

echo Pilihan tidak valid!
pause
goto menu

:: ===== ACTION PLACEHOLDERS =====
:ApkNodeJs
echo Menjalankan Node.js Installer...
start "Node.js Installer" "namaFileNodeJs.exe"
pause
goto apkMenu

:ApkComposser
echo Menjalankan Composer Installer...
start "Composer Installer" "namaFileComposer.exe"
pause
goto apkMenu

:ApkImagickHDRI
echo Menjalankan Imagick HDRI Installer...
start "Imagick HDRI Installer" "namaFileImagickHDRI.exe"
pause
goto apkMenu

:ApkTablePlus
echo Menjalankan TablePlus Installer...
start "TablePlus Installer" "namaFileTablePlus.exe"
pause
goto apkMenu

:ApkUltraViewer
echo Menjalankan UltraViewer Installer...
start "UltraViewer Installer" "namaFileUltraViewer.exe"
pause
goto apkMenu

:ApkPCMobolity
echo Menjalankan PCMobility Installer...
start "PCMobility Installer" "namaFilePCMobility.exe"
pause
goto apkMenu

:OserTskm
cls
color 0A
echo ====================================================^|
echo Task Manager :
echo ====================================================^|
echo Membuka Task Manager
start taskmgr
pause
goto menu

:OserTskSchedule
cls
color 0A
echo ====================================================^|
echo Task Manager :
echo ====================================================^|
echo Membuka Task Schedule
start taskschd.msc
pause
goto menu

:OserCreateTskSchedule
cls
color 0A
echo ====================================================^|
echo Task Scheduler - Tambah Task
echo ====================================================^|
echo.

:: Input nama task
set /p taskName=Masukkan nama task (default: MyNodeTask): 
if "%taskName%"=="" set taskName=MyNodeTask

:: Input path executable / script
set /p exePath=Masukkan path file executable (.exe / .bat / Node.js script): 

:: Tampilkan contoh path untuk berbagai tipe file
echo Contoh path untuk Node.js script:
echo "C:\Program Files\nodejs\node.exe" "C:\laragon\www\siakad\whatsapp\server.js"
echo Contoh path untuk file .bat:
echo "C:\laragon\www\siakad\whatsapp\startServer.bat"
echo Contoh path untuk file .exe:
echo "C:\Program Files\SomeApp\app.exe"

if "%exePath%"=="" (
    echo Error: Path harus diisi!
    pause
    goto menu
)

:: Pilih trigger schedule
echo.
echo Pilih trigger:
echo 1. Saat logon user
echo 2. Harian / Daily
echo 3. Saat startup
set /p trigger=Pilih trigger [1-3]: 

if "%trigger%"=="1" (
    set schTrigger=ONLOGON
) else if "%trigger%"=="2" (
    set /p schTime=Masukkan waktu (HH:MM, contoh 08:00): 
    set schTrigger=DAILY /ST %schTime%
) else if "%trigger%"=="3" (
    set schTrigger=ONSTARTUP
) else (
    echo Pilihan tidak valid!
    pause
    goto menu
)

:: Pilih hak eksekusi
echo.
echo Pilih hak eksekusi:
echo 1. Run only when user is logged on
echo 2. Run whether user is logged on or not
set /p runLevel=Pilih level [1-2]: 
if "%runLevel%"=="1" (
    set runOpt=/RL LIMITED
) else (
    set runOpt=/RL HIGHEST
)

:: Buat task
schtasks /create /tn "%taskName%" /tr "%exePath%" /sc %schTrigger% %runOpt% /f

echo.
echo Task "%taskName%" berhasil dibuat!
pause
goto menu

:nssmCreateSC
cls
color 0A
echo ====================================================^|
echo NSSM - Buat Service
echo ====================================================^|
echo.

:: Input nama service
set /p serviceName=Masukkan nama service (default: MyNodeService): 
if "%serviceName%"=="" set serviceName=MyNodeService

:: Input path executable / script
set /p exePath=Masukkan path file executable (.exe / .bat / Node.js script): 
echo Contoh path untuk Node.js script:
echo "C:\Program Files\nodejs\node.exe" "C:\laragon\www\siakad\whatsapp\server.js"
echo Contoh path untuk file .bat:
echo "C:\laragon\www\siakad\whatsapp\startServer.bat"
echo Contoh path untuk file .exe:
echo "C:\Program Files\SomeApp\app.exe"

if "%exePath%"=="" (
    echo Error: Path harus diisi!
    pause
    goto menu
)

:: Input folder NSSM
set /p nssmFolder=Masukkan path folder NSSM (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%nssmFolder%"=="" set nssmFolder=C:\laragon\www\siakad\executor\nssm\win64

set NSSM="%nssmFolder%\nssm.exe"

:: Buat service
echo Membuat service %serviceName%...
%NSSM% install %serviceName% "%exePath%"
echo Service %serviceName% berhasil dibuat!
pause
goto menu

:OserServicesMsc
cls
color 0A
echo ====================================================^|
echo Task Manager :
echo ====================================================^|
echo Membuka Services
start services.msc
pause
goto menu




:RemoveService
cls
color 0A
echo ====================================================^|
echo Hapus Service Windows
echo ====================================================^|

:: Input nama service
set /p serviceName=Masukkan nama service yang ingin dihapus: 

if "%serviceName%"=="" (
    echo Nama service tidak boleh kosong!
    pause
    goto menu
)

echo Menghentikan service "%serviceName%"...
sc stop "%serviceName%"
timeout /t 3 >nul

echo Menghapus service "%serviceName%"...
sc delete "%serviceName%"
timeout /t 3 >nul

echo Service "%serviceName%" telah dihapus (jika ada).
pause
goto menu



:PCrestart
cls
color 0A
echo ====================================================^|
echo Menghapus Semua Session dan Cache :
echo ====================================================^|
echo Resrat PC dalam 10 Detik
timeout /t 10 >nul
shutdown /r /f /t 0
pause
goto menu
:PCShutdown
cls
color 0A
echo ====================================================^|
echo Menghapus Semua Session dan Cache :
echo ====================================================^|
echo Resrat PC dalam 10 Detik
timeout /t 10 >nul
shutdown /s /f /t 0
pause
goto menu
:PCClearTemp
cls
color 0A
echo ====================================================^|
echo Menghapus Semua Session dan Cache :
echo ====================================================^|
echo Membersihkan temp
echo Membersihkan folder TEMP...

:: Membersihkan TEMP folder pengguna
rd /s /q "%temp%"
mkdir "%temp%"

:: Membersihkan TEMP folder sistem
rd /s /q "C:\Windows\Temp"
mkdir "C:\Windows\Temp"

echo Pembersihan selesai.
@echo off
echo Membersihkan file sementara...
del /s /q %temp%\*
del /s /q C:\Windows\Temp\*
echo Membersihkan file Prefetch...
del /s /q C:\Windows\Prefetch\*
echo Proses selesai!
timeout /t 5
@echo off
taskkill /im explorer.exe
timeout /t 5
pause
goto menu
:PCClearRecycleBin
cls
color 0A
echo ====================================================^|
echo Menghapus Semua Recycle Bin :
echo ====================================================^|
echo Mengosongkan Recycle Bin...
PowerShell -Command "Clear-RecycleBin -Force -ErrorAction SilentlyContinue"
echo Selesai!
pause
goto menu
:delAll
cls
color 0A
echo ====================================================^|
echo Menghapus Semua Session dan Cache:
echo ====================================================^|
echo.
set /p folderPath=Masukkan path folder (default: C:\laragon\www\siakad\whatsapp): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\whatsapp
cd /d "%folderPath%"
echo Menghapus semua session...
bash -c "rm -rf .wwebjs_auth"
echo Menghapus semua cache...
bash -c "rm -rf .wwebjs_cache"
echo.
echo Selesai!
pause
goto menu


:delSession
cls
color 0A
echo ====================================================^|
echo Hapus SessionId : GuruId
echo ====================================================^|
set /p sessionId=Masukkan nama session (misal GuruId): 
echo Menghapus session !sessionId!...
bash -c "rm -rf .wwebjs_auth/session-!sessionId!"
bash -c "rm -rf .wwebjs_cache/session-!sessionId!"
echo Selesai!
pause
goto menu

:delCache
cls
color 0A
echo ====================================================^|
echo Menghapus Cache :
echo ====================================================^|
echo Menghapus cache...
bash -c "rm -rf .wwebjs_cache"
echo Selesai!
pause
goto menu

:reinstallModules
cls
color 0A
echo ====================================================^|
echo Instal Ulang Modul :
echo ====================================================^|
echo Menghapus node_modules...
bash -c "rm -rf node_modules"
echo Install ulang modules...
npm install
echo Selesai!
pause
goto menu

:installObfuscator
cls
color 0A
echo ====================================================^|
echo Instal JS - Obfuscator :
echo ====================================================^|
echo Menginstal javascript-obfuscator...
npm install -g javascript-obfuscator
echo Selesai!
pause
goto menu

:encryptServer
cls
color 0A
echo ====================================================^|
echo Enscript Server :
echo ====================================================^|
set /p serverFile=Masukkan nama file server.js (default: server.js): 
if "%serverFile%"=="" set serverFile=server.js
echo Menjalankan obfuscator di !serverFile!...
javascript-obfuscator "!serverFile!" --output server-obfuscated.js --compact true --control-flow-flattening true
echo Selesai! Output: server-obfuscated.js
pause
goto menu


:backup
cls
color 0A
echo ====================================================^|
echo Backup Session & Cache :
echo ====================================================^|
echo Membuat backup session & cache...
set timestamp=%date:~10,4%%date:~7,2%%date:~4,2%_%time:~0,2%%time:~3,2%%time:~6,2%
mkdir backup\!timestamp!
bash -c "cp -r .wwebjs_auth backup/!timestamp!/wwebjs_auth"
bash -c "cp -r .wwebjs_cache backup/!timestamp!/wwebjs_cache"
echo Backup selesai: backup\!timestamp!
pause
goto menu

:restartServer
cls
color 0A
echo ====================================================^|
echo Restart server :
echo ====================================================^|
echo Matikan Service WhatsApp Server...
echo.

:: Input folder NSSM
set /p folderPath=Masukkan path folder NSSM (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64
cd /d "%folderPath%"

sc stop myNodeserver
timeout /t 5 >nul
sc stop LaravelSchedule
timeout /t 5 >nul
echo Proses stop service selesai...
timeout /t 3 >nul

:: Start Service
cls
echo ====================================================^|
echo Aktifkan Service WhatsApp Server...
echo ====================================================^|
sc start myNodeserver
timeout /t 5 >nul
sc start LaravelSchedule
timeout /t 5 >nul
echo Tunggu beberapa detik hingga status RUNNING...
timeout /t 5 >nul

:: Input folder PHP
set /p folderPathPhp=Masukkan path PHP (default: C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe): 
if "%folderPathPhp%"=="" set folderPathPhp=C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe

:: Path ke project Laravel
set projectDir=C:\laragon\www\siakad

:: Cek server Node
for /f %%i in ('curl -s -o nul -w "%%{http_code}" http://localhost:3000/status 2^>nul') do set status=%%i

if "%status%"=="200" (
    echo Server Aktif dan siap digunakan...
    cd /d %projectDir%
    echo Menjalankan artisan start:ServerAktif untuk informasi server on
    "%folderPathPhp%" artisan start:ServerAktif
    timeout /t 10 >nul
) else (
    echo Server tidak merespon, status=%status%
)

timeout /t 10 >nul
pause
goto menu

:clearLogs
cls
color 0A
echo ====================================================^|
echo Menghapus Log
echo ====================================================^|
echo Menghapus runwa.log...
bash -c "rm -f runwa.log"
echo Selesai!
pause
goto menu

:setupMyNode
cls
color 0A
echo ====================================================^|
echo Setup myNodeserver
echo ====================================================^|
echo.
:: copy paste kode setup myNodeserver di sini
set /p folderPath=Masukkan path folder (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64
set NSSM="%folderPath%\nssm.exe"

REM Matikan & hapus service lama
sc stop myNodeserver
sc delete myNodeserver

REM Bunuh node.exe yang nyangkut
for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install ulang service via NSSM
%nssm% install myNodeserver "C:\Program Files\nodejs\node.exe" "C:\laragon\www\siakad\whatsapp\server.js"

REM Set working directory
%nssm% set myNodeserver AppDirectory "C:\laragon\www\siakad\whatsapp"

REM Set restart otomatis
%nssm% set myNodeserver AppExit Default Restart
%nssm% set myNodeserver AppThrottle 5000
%nssm% set myNodeserver AppStopMethodSkip 6


REM Start service
sc start myNodeserver

REM Cek status
sc query myNodeserver
pause
goto menu

:setupLaravelSchedule
cls
color 0A
echo ====================================================^|
echo Setup LaravelSchedule
echo ====================================================^|
echo.
:: copy paste kode setup LaravelSchedule di sini
set /p folderPath=Masukkan path folder (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64

set NSSM="%folderPath%\nssm.exe"

REM Stop & delete service lama
sc stop LaravelSchedule
sc delete LaravelSchedule

REM Bunuh node.exe yang nyangkut (optional)
for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install ulang service via NSSM
%NSSM% install LaravelSchedule C:\Windows\System32\cmd.exe "/c C:\laragon\www\siakad\whatsapp\schedule.bat"

REM Set working directory
%NSSM% set LaravelSchedule AppDirectory C:\laragon\www\siakad\whatsapp

REM Set restart otomatis
%NSSM% set LaravelSchedule AppExit Default Restart

REM Start service
sc start LaravelSchedule

REM Cek status
sc query LaravelSchedule
pause
pause
goto menu

:setupBothServices
cls
color 0A
echo ====================================================^|
echo Setup myNodeserver dan LaravelSchedule
echo ====================================================^|
echo Men-setup service myNodeserver dan LaravelSchedule...
:: copy paste kode setup kedua service di sini
set /p folderPath=Masukkan path folder (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64
set NSSM="%folderPath%\nssm.exe"

REM Matikan & hapus service lama
sc stop myNodeserver
sc delete myNodeserver

REM Bunuh node.exe yang nyangkut
for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install ulang service via NSSM
%nssm% install myNodeserver "C:\Program Files\nodejs\node.exe" "C:\laragon\www\siakad\whatsapp\server.js"

REM Set working directory
%nssm% set myNodeserver AppDirectory "C:\laragon\www\siakad\whatsapp"

REM Set restart otomatis
%nssm% set myNodeserver AppExit Default Restart
%nssm% set myNodeserver AppThrottle 5000
%nssm% set myNodeserver AppStopMethodSkip 6


REM Start service
sc start myNodeserver

REM Cek status
sc query myNodeserver

'@echo off
'set NSSM=C:\laragon\www\siakad\executor\nssm\win64\nssm.exe

REM Stop & delete service lama
sc stop LaravelSchedule
sc delete LaravelSchedule

REM Bunuh node.exe yang nyangkut (optional)
'for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install ulang service via NSSM
%NSSM% install LaravelSchedule C:\Windows\System32\cmd.exe "/c C:\laragon\www\siakad\whatsapp\schedule.bat"

REM Set working directory
%NSSM% set LaravelSchedule AppDirectory C:\laragon\www\siakad\whatsapp

REM Set restart otomatis
%NSSM% set LaravelSchedule AppExit Default Restart

REM Start service
sc start LaravelSchedule

REM Cek status
sc query LaravelSchedule
pause
goto menu

:removeMyNode
cls
color 0A
echo ====================================================^|
echo Menghapus Service : myNodeserver atau LaravelSchedule
echo ====================================================^|
set /p serviceName=Masukkan nama service myNodeserver (default: myNodeserver): 
if "%serviceName%"=="" set serviceName=myNodeserver
echo Menghapus service !serviceName!...
:: Coba stop service dulu, ignore error jika service tidak jalan
sc stop "!serviceName!" >nul 2>&1
:: Hapus service
sc delete "!serviceName!" >nul 2>&1
echo Service "!serviceName!" telah dihapus.
pause
goto menu

:removeLaravelSchedule
cls
color 0A
echo ====================================================^|
echo Menghapus Service LaravelSchedule
echo ====================================================^|
echo Menghapus service LaravelSchedule...
:: Stop service dulu, ignore error jika service tidak jalan
sc stop LaravelSchedule >nul 2>&1
:: Hapus service
sc delete LaravelSchedule >nul 2>&1
echo Service "LaravelSchedule" telah dihapus.
pause
goto menu
:checkServices
cls
color 0A
echo ====================================================^|
echo Mengecek Status Services myNodeserver & LaravelSchedule
echo ====================================================^|
echo.

:: Input folder NSSM dan PHP
set /p folderPath=Masukkan path folder NSSM (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64

:: set /p folderPathPhp=Masukkan path PHP (default: C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe):
:: if "%folderPathPhp%"=="" set folderPathPhp=C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe
:: cd /d "%folderPath%"

:: Cek status service
echo Mengecek status service...
sc query myNodeserver
sc query LaravelSchedule

:: Cek status server Laravel
for /f %%i in ('curl -s -o nul -w "%%{http_code}" http://localhost:3000/status 2^>nul') do set status=%%i

:: Jalankan artisan command
set projectDir=C:\laragon\www\siakad
cd /d "%projectDir%"
"%folderPathPhp%" "%projectDir%\artisan" start:ServerAktif

echo.
if "%status%"=="200" (
    echo Server Aktif dan siap digunakan
) else (
    echo Server tidak merespon, status=%status%
)

pause
goto menu


:startServices
cls  
color 0A
echo ====================================================^|
echo Start Service : myNodeserver dan LaravelSchedule
echo ====================================================^|
echo Menjalankan service...
:: copy paste kode start service
set /p folderPath=Masukkan path folder (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64

:: Pindah ke folder tersebut
cd /d "%folderPath%"
sc start myNodeserver
sc start LaravelSchedule
timeout /t 5 >nul
sc query myNodeserver
sc query LaravelSchedule
curl http://localhost:3000
pause
goto menu
:restartServices
cls
color 0A
echo ====================================================^|
echo Restart Service myNodeserver & LaravelSchedule
echo ====================================================^|
echo.

:: Input folder NSSM & PHP
set /p folderPath=Masukkan path folder NSSM (default: C:\laragon\www\siakad\executor\nssm\win64): 
if "%folderPath%"=="" set folderPath=C:\laragon\www\siakad\executor\nssm\win64

set /p folderPathPhp=Masukkan path PHP (default: C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe):
if "%folderPathPhp%"=="" set folderPathPhp=C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe

:: Path project Laravel
set projectDir=C:\laragon\www\siakad

:: Stop Service
cls
echo ====================================================^|
echo Mematikan Service...
echo ====================================================^|
cd /d "%folderPath%"
sc stop myNodeserver
timeout /t 5 >nul
sc stop LaravelSchedule
timeout /t 5 >nul
echo Proses stop service selesai.
timeout /t 3 >nul

:: Start Service
cls
echo ====================================================^|
echo Mengaktifkan Service...
echo ====================================================^|
sc start myNodeserver
timeout /t 5 >nul
sc start LaravelSchedule
timeout /t 5 >nul
echo Tunggu beberapa detik hingga status RUNNING...
timeout /t 5 >nul

:: Cek status service
sc query myNodeserver
sc query LaravelSchedule
timeout /t 3 >nul

:: Cek status server Laravel
for /f %%i in ('curl -s -o nul -w "%%{http_code}" http://localhost:3000/status 2^>nul') do set status=%%i

if "%status%"=="200" (
    echo Server Aktif dan siap digunakan...
    cd /d %projectDir%
    "%folderPathPhp%" artisan start:ServerAktif
    timeout /t 5 >nul
) else (
    echo Server tidak merespon, status=%status%
)

pause
goto menu

:reinitMySQL
cls
color 0A
echo ====================================================^|
echo Reinitialize MySql
echo ====================================================^|
echo Reinitialize MySQL...
:: copy paste kode reinitialize MySQL
echo === Inisialisasi ulang MySQL ===
cd C:\laragon\bin\mysql\mysql-8.3.0-winx64\bin

rem hapus folder data lama (WARNING: semua database hilang)
rmdir /S /Q ..\data

rem bikin ulang folder data kosong
mkdir ..\data

rem initialize ulang
mysqld --initialize-insecure --user=mysql --console

echo === Selesai. Coba start MySQL lagi ===
pause
goto menu

:cloneRepo
cls
color 0A
echo ====================================================^|
echo Clone Repo : WhatsApp
echo ====================================================^|
echo Cloning WhatsApp repo...
git clone https://github.com/EmsinaDR/whatsapp.git
pause
goto menu

:reserved
echo Menu reserved, belum diimplementasikan.
pause
goto menu
