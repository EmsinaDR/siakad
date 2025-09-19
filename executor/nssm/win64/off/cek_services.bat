@echo off
cd /d C:\laragon\www\siakad\executor\nssm\win64

sc query myNodeserver
sc query LaravelSchedule
sc query NgrokService
pause

curl http://localhost:3000

C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\php.exe artisan start:ServerAktif

pause
cls
for /f %%i in ('curl -s -o nul -w "%%{http_code}" http://localhost:3000/status 2^>nul') do set status=%%i

if "%status%"=="200" (
    echo Server Aktif dan siap digunakan
) else (
    echo Server tidak merespon, status=%status%
)
pause