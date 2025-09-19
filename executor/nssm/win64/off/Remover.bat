@echo off
:MENU
cls
echo ================================
echo        SERVICE MANAGER
echo ================================
echo [1] Hentikan ^& hapus myNodeserver
echo [2] Hentikan ^& hapus LaravelSchedule
echo [3] Hentikan ^& hapus NgrokService
echo [4] Hentikan ^& hapus SEMUA service
echo [0] Keluar
echo ================================
choice /c 12340 /n /m "Pilih opsi: "

REM Cek input (errorlevel harus dari besar ke kecil)
if errorlevel 5 goto EXIT
if errorlevel 4 goto ALL
if errorlevel 3 goto NGROK
if errorlevel 2 goto LARAVEL
if errorlevel 1 goto NODE

goto MENU

:NODE
echo Menghentikan myNodeserver...
sc stop myNodeserver
sc delete myNodeserver
pause
goto MENU

:LARAVEL
echo Menghentikan LaravelSchedule...
sc stop LaravelSchedule
sc delete LaravelSchedule
pause
goto MENU

:NGROK
echo Menghentikan NgrokService...
sc stop NgrokService
sc delete NgrokService
pause
goto MENU

:ALL
echo Menghentikan SEMUA service...
sc stop myNodeserver
sc delete myNodeserver
sc stop LaravelSchedule
sc delete LaravelSchedule
sc stop NgrokService
sc delete NgrokService
pause
goto MENU

:EXIT
echo Keluar...
exit
