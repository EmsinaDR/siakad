@echo off
:LOOP
echo Membersihkan TEMP pengguna...
for /f "delims=" %%F in ('dir /b /a "%temp%"') do (
    del /f /q "%temp%\%%F" 2>nul
)

echo Membersihkan TEMP sistem...
for /f "delims=" %%F in ('dir /b /a "C:\Windows\Temp"') do (
    del /f /q "C:\Windows\Temp\%%F" 2>nul
)

echo Membersihkan Prefetch...
for /f "delims=" %%F in ('dir /b /a "C:\Windows\Prefetch"') do (
    del /f /q "C:\Windows\Prefetch\%%F" 2>nul
)

echo Pembersihan selesai. Tunggu 10 menit sebelum loop berikutnya...
REM timeout /t 600 >nul
goto LOOP
