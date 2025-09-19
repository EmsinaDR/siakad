@echo off
echo ================================
echo      DAFTAR ADAPTER ETHERNET
echo ================================
echo.

:: List adapter Ethernet yang aktif
for /f "tokens=*" %%A in ('netsh interface show interface ^| findstr "Connected"') do (
    echo %%A
)

echo.
set /p INTERFACE=Masukkan nama adapter dari daftar di atas: 
for /f "tokens=* delims= " %%A in ("%INTERFACE%") do set INTERFACE=%%A

:: Tampilkan IP saat ini
for /f "tokens=2 delims=:" %%A in ('netsh interface ip show addresses name^="%INTERFACE%" ^| find "IP Address"') do set CURRENT_IP=%%A
echo IP saat ini: %CURRENT_IP%

:: Input IP baru
set /p NEW_IP=Masukkan IP baru: 

:: Gunakan default subnet mask
set MASK=255.255.255.0

:: Ambil gateway lama
for /f "tokens=2 delims=:" %%A in ('netsh interface ip show addresses name^="%INTERFACE%" ^| find "Default Gateway"') do set GATEWAY=%%A
set GATEWAY=%GATEWAY:~1%

:: Set IP baru
netsh interface ip set address name="%INTERFACE%" static %NEW_IP% %MASK% %GATEWAY% >nul 2>&1

:: Delay sebentar supaya Windows update IP
ping 127.0.0.1 -n 3 >nul

:: Set DNS primary dan secondary dengan format benar, error disembunyikan
netsh interface ip set dns name="%INTERFACE%" source=static addr=8.8.8.8 register=primary >nul 2>&1
netsh interface ip add dns name="%INTERFACE%" addr=8.8.4.4 index=2 >nul 2>&1

echo.
echo IP adapter %INTERFACE% sudah diubah ke %NEW_IP% dengan DNS 8.8.8.8 ^& 8.8.4.4
timeout /t 5 /nobreak >nul


