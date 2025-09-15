@echo off
:: ================================
:: Script Git Commit + Push cepat
:: ================================

:: Minta input pesan commit
set /p commitmsg=Masukkan pesan commit: 

:: Kalau kosong, kasih default
if "%commitmsg%"=="" (
    set commitmsg=Auto commit
)

git add .
git commit -m "%commitmsg%"
git push origin main

echo.
echo ================================
echo Push selesai!
pause
