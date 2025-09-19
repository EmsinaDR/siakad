echo Instal obfuscator
echo Ubah server.js jadi server-locked.js
cd /d C:\laragon\www\siakad\whatsapp

:: ambil tanggal (format YYYYMMDD-HHMMSS biar unik)
for /f "tokens=2 delims==" %%I in ('"wmic os get localdatetime /value"') do set datetime=%%I
set datestamp=%datetime:~0,8%-%datetime:~8,6%

:: backup server.js ke file baru
copy server.js server_%datestamp%.bak

:: install obfuscator global (kalau belum ada)
npm list -g javascript-obfuscator >nul 2>&1
if errorlevel 1 npm install -g javascript-obfuscator

:: obfuscate
javascript-obfuscator server.js --output server-locked.js

echo === DONE! server.js sudah di-backup dan di-obfuscate ===
pause

