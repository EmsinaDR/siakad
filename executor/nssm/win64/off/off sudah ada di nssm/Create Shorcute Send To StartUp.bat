@echo off
set TARGET=C:\laragon\www\siakad\executor\myapp.exe
set SHORTCUT_NAME=MyApp

:: cari folder startup user
for /f "tokens=2*" %%a in ('reg query "HKCU\Software\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders" /v Startup ^| find "Startup"') do set STARTUP_FOLDER=%%b

:: bikin vbscript sementara
echo Set oWS = WScript.CreateObject("WScript.Shell") > "%TEMP%\mkshortcut.vbs"
echo sLinkFile = "%STARTUP_FOLDER%\%SHORTCUT_NAME%.lnk" >> "%TEMP%\mkshortcut.vbs"
echo Set oLink = oWS.CreateShortcut(sLinkFile) >> "%TEMP%\mkshortcut.vbs"
echo oLink.TargetPath = "%TARGET%" >> "%TEMP%\mkshortcut.vbs"
echo oLink.WorkingDirectory = "C:\laragon\www\siakad\executor" >> "%TEMP%\mkshortcut.vbs"
echo oLink.IconLocation = "%TARGET%,0" >> "%TEMP%\mkshortcut.vbs"
echo oLink.Save >> "%TEMP%\mkshortcut.vbs"

:: jalanin vbscript
cscript //nologo "%TEMP%\mkshortcut.vbs"

:: hapus script sementara
del "%TEMP%\mkshortcut.vbs"

echo Shortcut berhasil dibuat di Startup!
pause
