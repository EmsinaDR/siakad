@echo off
title Ekstrak dan Update File
'ekstrak file /.rar dan kirim ke folder tujuan
set UPDFOLDER=C:\laragon\www\siakad\executor\update
set DESTFOLDER=C:\laragon\www\siakad\executor

cd /d "%UPDFOLDER%"

:: ekstrak rar ke folder update
"%ProgramFiles%\WinRAR\WinRAR.exe" x -y "*.rar" "%UPDFOLDER%\"

:: pindahkan hasil ekstrak ke folder tujuan, overwrite jika ada
xcopy "%UPDFOLDER%\*" "%DESTFOLDER%\" /E /H /Y

echo Update selesai!
pause
