@echo off
REM ================================
REM :: Backup Database MySQL (langsung jalan)
REM ================================

cd /d C:\laragon\bin\mysql\mysql-8.3.0-winx64\bin

REM Ambil tanggal sekarang (YYYYMMDD)
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value ^| find "="') do set datetime=%%I
set today=%datetime:~0,8%

REM Nama database yang mau dibackup
set dbname=siakad

REM Folder tujuan backup
set backup_dir=C:\laragon\www\siakad\executor\nssm\win64\db_backup

if not exist "%backup_dir%" mkdir "%backup_dir%"

echo Backup database "%dbname%"...
mysqldump -uroot -hlocalhost %dbname% > "%backup_dir%\%dbname%_%today%.sql"

if %errorlevel%==0 (
    echo Backup selesai: %backup_dir%\%dbname%_%today%.sql
) else (
    echo Backup gagal!
)

timeout /t 3 >nul
