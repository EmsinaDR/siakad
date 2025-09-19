@echo off
setlocal enabledelayedexpansion

for /l %%i in (1,1,20) do (
    echo Hitung: %%i
    timeout /t 1 >nul
)

echo.
echo Selesai! Tekan tombol apapun untuk keluar...
pause >nul
