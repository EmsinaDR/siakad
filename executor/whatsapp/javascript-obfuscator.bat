@echo off
cd /d C:\laragon\www\siakad\whatsapp

:: Jika javascript-obfuscator belum terinstall, uncomment baris di bawah
:: npm install -g javascript-obfuscator

javascript-obfuscator server.js --output server-locked.js
pause
