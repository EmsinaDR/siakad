@echo off
setlocal enabledelayedexpansion
title "WhatsApp/Web.js Maintenance Menu"
:menu
cls
echo ==============================
echo     WhatsApp Project Menu
echo ==============================
echo 1. Hapus Semua Session ^& Cache
echo 2. Hapus Session Tertentu
echo 3. Hapus Cache
echo 4. Hapus ^& Install Ulang Node Modules
echo 5. Instal Obfuscator
echo 6. Enscript Server.js
echo 7. Backup Session ^& Cache
echo 8. Restart Server
echo 9. Clear Logs
echo 10. Setup service myNodeserver
echo 11. Setup service LaravelSchedule
echo 12. Setup service myNodeserver ^& LaravelSchedule
echo 13. Remove service myNodeserver
echo 14. Remove service LaravelSchedule
echo 15. Cek service myNodeserver ^& LaravelSchedule
echo 17. Start Service
echo 18. Restart Service
echo 19. Reinitialize MySQL
echo 0. Keluar
echo ==============================

set /p choice=Masukkan pilihan: 

if "%choice%"=="1" goto delAll
if "%choice%"=="2" goto delSession
if "%choice%"=="3" goto delCache
if "%choice%"=="4" goto reinstallModules
if "%choice%"=="5" goto installObfuscator
if "%choice%"=="6" goto encryptServer
if "%choice%"=="7" goto backup
if "%choice%"=="8" goto restartServer
if "%choice%"=="9" goto clearLogs
if "%choice%"=="10" goto setupMyNode
if "%choice%"=="11" goto setupLaravelSchedule
if "%choice%"=="12" goto setupBothServices
if "%choice%"=="13" goto removeMyNode
if "%choice%"=="14" goto removeLaravelSchedule
if "%choice%"=="15" goto checkServices
if "%choice%"=="17" goto startServices
if "%choice%"=="18" goto restartServices
if "%choice%"=="19" goto reinitMySQL
if "%choice%"=="0" exit

echo "Pilihan tidak valid!"
pause
goto menu

:delAll
echo "Menghapus semua session & cache..."
bash -c "rm -rf .wwebjs_auth"
bash -c "rm -rf .wwebjs_cache"
echo "Selesai!"
pause
goto menu

:delSession
set /p sessionId=Masukkan nama session (misal GuruId): 
echo "Menghapus session !sessionId!..."
bash -c "rm -rf .wwebjs_auth/session-!sessionId!"
bash -c "rm -rf .wwebjs_cache/session-!sessionId!"
echo "Selesai!"
pause
goto menu

:delCache
echo "Menghapus cache..."
bash -c "rm -rf .wwebjs_cache"
echo "Selesai!"
pause
goto menu

:reinstallModules
echo "Menghapus node_modules..."
bash -c "rm -rf node_modules"
echo "Install ulang modules..."
npm install
echo "Selesai!"
pause
goto menu

:installObfuscator
echo "Menginstal javascript-obfuscator..."
npm install -g javascript-obfuscator
echo "Selesai!"
pause
goto menu

:encryptServer
echo "Menjalankan obfuscator di server.js..."
javascript-obfuscator server.js --output server-obfuscated.js --compact true --control-flow-flattening true
echo "Selesai! Output: server-obfuscated.js"
pause
goto menu

:backup
echo "Membuat backup session & cache..."
set timestamp=%date:~10,4%%date:~7,2%%date:~4,2%_%time:~0,2%%time:~3,2%%time:~6,2%
mkdir backup\!timestamp!
bash -c "cp -r .wwebjs_auth backup/!timestamp!/wwebjs_auth"
bash -c "cp -r .wwebjs_cache backup/!timestamp!/wwebjs_cache"
echo "Backup selesai: backup\!timestamp!"
pause
goto menu

:restartServer
echo "Restart server Node.js..."
taskkill /F /IM node.exe
echo "Menjalankan server..."
start cmd /k "node server.js"
pause
goto menu

:clearLogs
echo "Menghapus runwa.log..."
bash -c "rm -f runwa.log"
echo "Selesai!"
pause
goto menu

:: ===== SERVICE & MYSQL BLOCK =====

:setupMyNode
echo "Men-setup service myNodeserver..."
:: kode setup myNodeserver sudah ada, tinggal copy paste di sini
pause
goto menu

:setupLaravelSchedule
echo "Men-setup service LaravelSchedule..."
:: kode setup LaravelSchedule sudah ada, tinggal copy paste di sini
pause
goto menu

:setupBothServices
echo "Men-setup service myNodeserver dan LaravelSchedule..."
:: kode setup kedua service sudah ada, tinggal copy paste di sini
pause
goto menu

:removeMyNode
set /p serviceName=Masukkan nama service myNodeserver (default: myNodeserver): 
if "%serviceName%"=="" set serviceName=myNodeserver
echo "Menghapus service !serviceName!..."
:: kode remove service sudah ada, tinggal copy paste di sini
pause
goto menu

:removeLaravelSchedule
echo "Menghapus service LaravelSchedule..."
:: kode remove LaravelSchedule sudah ada, tinggal copy paste di sini
pause
goto menu

:checkServices
echo "Mengecek status service myNodeserver dan LaravelSchedule..."
:: kode cek status service sudah ada, tinggal copy paste di sini
pause
goto menu

:startServices
echo "Menjalankan service..."
:: kode start service sudah ada, tinggal copy paste di sini
pause
goto menu

:restartServices
echo "Restart service..."
:: kode restart service sudah ada, tinggal copy paste di sini
pause
goto menu

:reinitMySQL
echo "Reinitialize MySQL..."
:: kode reinitialize MySQL sudah ada, tinggal copy paste di sini
pause
goto menu
