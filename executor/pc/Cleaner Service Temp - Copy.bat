@echo off
echo Membersihkan folder TEMP...

:: Membersihkan TEMP folder pengguna
rd /s /q "%temp%"
mkdir "%temp%"

:: Membersihkan TEMP folder sistem
rd /s /q "C:\Windows\Temp"
mkdir "C:\Windows\Temp"

echo Pembersihan selesai.
'pause

@echo off
echo Membersihkan file sementara...
del /s /q %temp%\*
del /s /q C:\Windows\Temp\*
echo Membersihkan file Prefetch...
del /s /q C:\Windows\Prefetch\*
echo Proses selesai!

timeout /t 600 >nul
goto LOOP
'pause

timeout /t 5
@echo off
taskkill /im explorer.exe
timeout /t 5
start explorer.exe