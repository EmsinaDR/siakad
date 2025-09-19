@echo off

REM Path nssm.exe full
set NSSM="C:\laragon\www\siakad\executor\nssm\win64\nssm.exe"

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
REM pause
