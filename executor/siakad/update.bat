@echo off
SET UPDATE_DIR=C:\laragon\www\siakad\update
::SET DEST=C:\laragon\www\siakad\updatenew : Dev
::SET DEST=C:\laragon\www\siakad : Real
SET DEST=C:\laragon\www\siakad


:: Hapus folder update jika ada
IF EXIST "%UPDATE_DIR%" (
    echo Folder update ada, hapus isinya...
    rmdir /S /Q "%UPDATE_DIR%"
)

:: Buat folder update kosong
mkdir "%UPDATE_DIR%"

:: Clone repo langsung ke folder ini
cd /d "%UPDATE_DIR%"
git clone https://github.com/EmsinaDR/siakad.git .

:: Jeda 10 detik biar Git selesai “melepaskan” file
echo Menunggu sebentar...
timeout /t 5

:: Buat folder tujuan jika belum ada
IF NOT EXIST "%DEST%" mkdir "%DEST%"

:: Salin semua isi folder update ke updatenew termasuk file tersembunyi
echo Menyalin semua isi folder update ke updatenew...
xcopy "%UPDATE_DIR%\*" "%DEST%\" /E /H /K /Y

timeout /t 2
:: Hapus folder update setelah selesai
echo ====================================
echo Proses Hapus Update
echo ====================================

rmdir /S /Q "%UPDATE_DIR%"

echo ✅ Update selesai, semua file ada di updatenew
exit
::pause
