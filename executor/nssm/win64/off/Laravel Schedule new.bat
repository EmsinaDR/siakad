@echo off
REM ===========================
REM NSSM Script - LaravelSchedule
REM ===========================

set NSSM=C:\laragon\www\siakad\executor\nssm\win64\nssm.exe
set SERVICE_NAME=LaravelSchedule
set WORK_DIR=C:\laragon\www\siakad\whatsapp
set BATCH_FILE=%WORK_DIR%\schedule.bat

REM Stop & delete service lama (tunggu sebentar)
sc stop %SERVICE_NAME%
timeout /t 2 /nobreak >nul
sc delete %SERVICE_NAME%
timeout /t 2 /nobreak >nul

REM Bunuh node.exe khusus server schedule (opsional, bisa di-comment)
REM for /f "tokens=2" %%a in ('tasklist ^| find /i "node.exe"') do taskkill /F /PID %%a

REM Install service via NSSM
%NSSM% install %SERVICE_NAME% C:\Windows\System32\cmd.exe /c "%BATCH_FILE%"

REM Set working directory
%NSSM% set %SERVICE_NAME% AppDirectory %WORK_DIR%

REM Set restart otomatis jika exit
%NSSM% set %SERVICE_NAME% AppExit Default Restart

REM Redirect log (opsional tapi disarankan)
%NSSM% set %SERVICE_NAME% AppStdout %WORK_DIR%\schedule.log
%NSSM% set %SERVICE_NAME% AppStderr %WORK_DIR%\schedule.err

REM Start service
sc start %SERVICE_NAME%

REM Cek status
sc query %SERVICE_NAME%
pause
