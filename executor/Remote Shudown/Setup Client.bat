@echo off
:: setup-remote.bat
:: 1-klik untuk enable WinRM, buka firewall, enable RemoteRegistry (untuk PsExec)
:: Harus dijalankan sebagai Administrator

:: ---- check admin ----
openfiles >nul 2>&1
if %errorlevel% neq 0 (
    echo =========================================================
    echo THIS SCRIPT REQUIRES ADMIN RIGHTS. Re-running with elevation...
    echo =========================================================
    powershell -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
    exit /b
)

echo Running as Administrator. Mulai konfigurasi... 
echo.

:: ---- jalankan perintah PowerShell yang diperlukan ----
powershell -NoProfile -ExecutionPolicy Bypass -Command ^
"Try {
    Write-Host '1) Enable WinRM (PowerShell Remoting)...' -ForegroundColor Cyan
    # Enable remoting
    Enable-PSRemoting -Force -ErrorAction Stop

    Write-Host '2) Pastikan service WinRM Auto & Running...' -ForegroundColor Cyan
    Set-Service -Name WinRM -StartupType Automatic -ErrorAction SilentlyContinue
    if ((Get-Service -Name WinRM).Status -ne 'Running') { Start-Service -Name WinRM }

    Write-Host '3) Configure WinRM listener & settings (http listener)...' -ForegroundColor Cyan
    winrm quickconfig -q | Out-Null

    Write-Host '4) Open firewall rules for WinRM & File and Printer Sharing...' -ForegroundColor Cyan
    netsh advfirewall firewall set rule group=\"Windows Remote Management\" new enable=Yes > $null
    netsh advfirewall firewall set rule group=\"File and Printer Sharing\" new enable=Yes > $null

    Write-Host '5) Enable Remote Registry service (required by PsExec remote operations)...' -ForegroundColor Cyan
    sc config RemoteRegistry start= auto | Out-Null
    sc start RemoteRegistry 2>$null

    Write-Host ''
    Write-Host '=== SELSESAI: ringkasan status ===' -ForegroundColor Green

    # status checks
    $winrm = Get-Service -Name WinRM -ErrorAction SilentlyContinue
    if ($winrm) { Write-Host \"WinRM: $($winrm.Status) (StartupType: $((Get-WmiObject -Class Win32_Service -Filter \"Name='WinRM'\").StartMode))\" }
    else { Write-Host 'WinRM: tidak ditemukan' }

    $rr = Get-Service -Name RemoteRegistry -ErrorAction SilentlyContinue
    if ($rr) { Write-Host \"RemoteRegistry: $($rr.Status)\" }

    Write-Host 'Firewall rules (WinRM):'
    netsh advfirewall firewall show rule name=all | Select-String -Pattern \"Windows Remote Management|File and Printer Sharing\" | Select-Object -First 10

    Write-Host ''
    Write-Host 'Catatan:' -ForegroundColor Yellow
    Write-Host ' - Jika mesin workgroup, pada mesin admin jalankan:'
    Write-Host '     Set-Item WSMan:\\localhost\\Client\\TrustedHosts -Value \"<ip-range atau *>\"'
    Write-Host ' - Jika ingin HTTPS/sertifikat atau lebih aman, konfigurasi tambahan diperlukan.'
} Catch {
    Write-Host 'ERROR saat konfigurasi: ' $_.Exception.Message -ForegroundColor Red
    Exit 1
} finally {
    Write-Host ''
}"
echo.
echo Selesai. Tekan enter untuk menutup...
pause >nul
exit /b
