@echo off
REM ===============================
REM Script otomatis push Git project
REM ===============================

copy server-locked.js server.js
copy server-locked.js server.bak

REM Ganti sesuai folder project jika perlu
cd /d "C:\laragon\www\siakad\whatsapp"

REM Tampilkan status Git
echo === STATUS GIT ===
git status

REM Tambahkan semua perubahan
git add .

REM Commit dengan pesan otomatis timestamp
set datetime=%date%_%time%
REM git commit -m "Auto commit %datetime%"
git commit -m "Auto commit Ata Digital"

REM Pull dulu untuk merge (hindari error non-fast-forward)
git pull origin main --allow-unrelated-histories --no-rebase

REM Push ke GitHub
git push origin main

echo.
echo ===============================
echo Push selesai!
pause
