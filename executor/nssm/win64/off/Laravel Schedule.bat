@echo off
set NSSM=C:\laragon\www\siakad\executor\nssm\win64\nssm.exe

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
REM pause
