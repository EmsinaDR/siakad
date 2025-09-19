@echo off
title Hapus semua BAT di executor dan subfolder

cd /d C:\laragon\www\siakad\executor
for /r %%i in (*.bat) do del /q "%%i"

echo Semua file .bat di folder ini dan subfolder sudah dihapus!
pause
