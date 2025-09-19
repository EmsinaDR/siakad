@echo off
REM Ganti sesuai IP yang diinginkan
set INTERFACE="Ethernet"
set IP=192.168.1.29
set MASK=255.255.255.0
set GATEWAY=192.168.1.1

netsh interface ip set address name=%INTERFACE% static %IP% %MASK% %GATEWAY%
netsh interface ip set dns name=%INTERFACE% static 8.8.8.8

echo IP adapter %INTERFACE% sudah diubah ke %IP%
pause
