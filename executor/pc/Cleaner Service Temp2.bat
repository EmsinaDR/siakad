@echo off
set "svc=TempCleaner"

:: ambil PID
for /f "tokens=2 delims=:" %%A in ('sc queryex "%svc%" ^| findstr /i "PID"') do set "pid=%%A"
for /f "tokens=* delims= " %%P in ("%pid%") do set "pid=%%P"

:: ambil status
for /f "tokens=3*" %%S in ('sc query "%svc%" ^| findstr /i "STATE"') do set "state=%%T"
for /f "tokens=* delims= " %%Z in ("%state%") do set "state=%%Z"

echo Status: %state%  PID: %pid%

if /i "%state%"=="PAUSED" (
    echo PAUSED → paksa hentikan proses PID %pid%...
    taskkill /F /PID %pid%
    timeout /t 1 >nul
)

echo Memulai ulang service...
sc start "%svc%"
sc query "%svc%"
pause
