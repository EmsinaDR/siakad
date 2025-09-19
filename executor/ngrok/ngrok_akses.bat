REM C:\laragon\bin\ngrok\ngrok.exe config add-authtoken 2h7xWx7MgexTga9HezcthXKhcjL_6aSw3WVi3isR8wea1xbnu
REM C:\laragon\bin\ngrok\ngrok.exe http --url=zella-subintimal-isabela.ngrok-free.app 80

@echo off
REM Baca token dari baris 1
setlocal enabledelayedexpansion
set /a count=0

for /f "usebackq delims=" %%a in ("C:\laragon\www\siakad\executor\ngrok\token.txt") do (
    set /a count+=1
    if !count! equ 1 set TOKEN=%%a
    if !count! equ 2 set SUBDOMAIN=%%a
)

REM Tambahkan token di ngrok
C:\laragon\bin\ngrok\ngrok.exe config add-authtoken %TOKEN%

REM Jalankan ngrok dengan subdomain dari file
C:\laragon\bin\ngrok\ngrok.exe http --url=%SUBDOMAIN% 80

echo Ngrok token dan subdomain berhasil digunakan!
pause
