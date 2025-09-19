@echo off

REM Path nssm.exe full (tanpa tanda kutip)
set NSSM=E:\laragon\etc\apps\nssm\win64\nssm.exe

REM Path nodemon global (sesuaikan)
set NPM_GLOBAL_PATH=%APPDATA%\npm
set NODEMON=%NPM_GLOBAL_PATH%\nodemon.cmd

if not exist "%NODEMON%" (
    echo [❌] nodemon.cmd tidak ditemukan, install dulu dengan npm install -g nodemon
    pause
    exit /b
)

REM Matikan & hapus service lama
sc stop myNodeserver
sc delete myNodeserver

REM Bunuh node.exe yang nyangkut
for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install ulang service via NSSM dengan nodemon
"%NSSM%" install myNodeserver "%NODEMON%" "server.js"

REM Set working directory
"%NSSM%" set myNodeserver AppDirectory "E:\laragon\www\siakad\whatsapp"

REM Set restart otomatis kalau keluar
"%NSSM%" set myNodeserver AppExit Default Restart

REM Start service
sc start myNodeserver

REM Cek status
sc query myNodeserver

pause
