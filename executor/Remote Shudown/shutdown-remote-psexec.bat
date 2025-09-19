@echo off
:: shutdown-remote-psexec.bat
:: Letakkan psexec.exe di folder ini atau PATH.
:: Jalankan sebagai Administrator pada mesin admin.

setlocal
set IPFILE=ipcomputer.txt
set PSEXEC=psexec.exe

if not exist %IPFILE% (
  echo File %IPFILE% tidak ditemukan.
  pause
  exit /b 1
)

if not exist %PSEXEC% (
  echo %PSEXEC% tidak ditemukan. Letakkan psexec.exe di folder ini atau ubah variabel PSEXEC.
  pause
  exit /b 1
)

echo Masukkan username (contoh: Administrator atau DOMAIN\AdminUser):
set /p USERNAME=Username:
echo Masukkan password (tidak ditampilkan):
<nul set /p= 
:: gunakan powershell untuk read-as-secure (agar nggak echo) lalu simpan ke variable (simple)
for /f "usebackq delims=" %%P in (`powershell -Command "Read-Host -AsSecureString 'Password' | ConvertFrom-SecureString"`) do set PASSSEC=%%P
:: convert PASSSEC back to plaintext for psexec (WARNING: insecure), do it in memory
for /f "usebackq delims=" %%Q in (`powershell -Command "$s = ConvertTo-SecureString '%PASSSEC%' ; $b = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($s)); Write-Output $b"`) do set PASSWORD=%%Q

echo.
echo Starting shutdown loop...
for /f "usebackq delims=" %%A in ("%IPFILE%") do (
  set IP=%%A
  call :ping_and_shutdown %%A
)
echo Done.
pause
exit /b

:ping_and_shutdown
setlocal
set IP=%1
echo -----------------------------
echo Checking %IP% ...
ping -n 1 %IP% >nul 2>&1
if errorlevel 1 (
  echo %IP% unreachable. Skipping.
  endlocal & goto :eof
)
echo %IP% reachable. Sending shutdown via PsExec...
%PSEXEC% \\%IP% -u %USERNAME% -p %PASSWORD% shutdown -s -t 0 -f
if errorlevel 1 (
  echo PsExec failed for %IP%.
) else (
  echo Shutdown command sent to %IP%.
)
endlocal
goto :eof
