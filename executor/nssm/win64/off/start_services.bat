@echo off
cd /d C:\laragon\www\siakad\executor\nssm\win64
sc start myNodeserver
sc start LaravelSchedule
timeout /t 5 >nul
sc query myNodeserver
sc query LaravelSchedule
curl http://localhost:3000
pause