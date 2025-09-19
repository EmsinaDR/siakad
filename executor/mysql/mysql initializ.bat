@echo off
echo === Inisialisasi ulang MySQL ===
cd C:\laragon\bin\mysql\mysql-8.3.0-winx64\bin

rem hapus folder data lama (WARNING: semua database hilang)
rmdir /S /Q ..\data

rem bikin ulang folder data kosong
mkdir ..\data

rem initialize ulang
mysqld --initialize-insecure --user=mysql --console

echo === Selesai. Coba start MySQL lagi ===
pause
