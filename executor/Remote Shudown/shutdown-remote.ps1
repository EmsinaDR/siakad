<#
shutdown-remote.ps1
Gunakan: Jalankan PowerShell sebagai Administrator.
Contoh: .\shutdown-remote.ps1         -> real run (minta credential)
       .\shutdown-remote.ps1 -WhatIf  -> dry run (tidak mematikan)
#>

param(
    [switch]$WhatIf
)

# file daftar IP (satu IP per baris)
$ipFile = ".\ipcomputer.txt"
$logFile = ".\shutdown-log.csv"

if (-not (Test-Path $ipFile)) {
    Write-Error "File $ipFile tidak ditemukan. Letakkan daftar IP (satu per baris) di file ini."
    exit 1
}

# Request credential untuk koneksi WinRM (domain\user atau komputer\user)
Write-Host "Masukkan credential admin untuk remote (akan dipakai untuk WinRM/Invoke-Command):" -ForegroundColor Cyan
$cred = Get-Credential

# initialize log
"Timestamp,IP,Method,Status,Message" | Out-File -FilePath $logFile -Encoding utf8

$ips = Get-Content -Path $ipFile | Where-Object {$_ -and $_.Trim() -ne ""} | ForEach-Object { $_.Trim() }

foreach ($ip in $ips) {
    $timestamp = (Get-Date).ToString("yyyy-MM-dd HH:mm:ss")
    Write-Host "`n=== $ip ===" -ForegroundColor Yellow

    # 1) cek online (ping)
    $online = Test-Connection -ComputerName $ip -Count 1 -Quiet -ErrorAction SilentlyContinue
    if (-not $online) {
        $msg = "Offline (no ping)"
        Write-Host $msg -ForegroundColor DarkRed
        "$timestamp,$ip,none,FAILED,$msg" >> $logFile
        continue
    } else {
        Write-Host "Host reachable (ping OK)" -ForegroundColor Green
    }

    # 2) cek WinRM/PowerShell Remoting
    $wsmanOk = $false
    try {
        Test-WSMan -ComputerName $ip -Credential $cred -ErrorAction Stop | Out-Null
        $wsmanOk = $true
    } catch {
        $wsmanOk = $false
    }

    if ($wsmanOk) {
        Write-Host "WinRM tersedia — akan gunakan Invoke-Command -> Stop-Computer" -ForegroundColor Green

        if ($WhatIf) {
            Write-Host "[DRY RUN] Would invoke Stop-Computer on $ip" -ForegroundColor Cyan
            "$timestamp,$ip,WinRM,DRYRUN,Would invoke Stop-Computer" >> $logFile
            continue
        }

        try {
            Invoke-Command -ComputerName $ip -Credential $cred -ScriptBlock {
                Stop-Computer -Force -Confirm:$false
            } -ErrorAction Stop -TimeoutSec 30
            Write-Host "Shutdown command sent via WinRM." -ForegroundColor Green
            "$timestamp,$ip,WinRM,OK,Shutdown command sent" >> $logFile
        } catch {
            $err = $_.Exception.Message -replace ",",";"  # avoid CSV breaks
            Write-Host "Gagal invoke Stop-Computer: $err" -ForegroundColor Red
            "$timestamp,$ip,WinRM,FAILED,$err" >> $logFile
        }
    } else {
        $msg = "WinRM tidak tersedia"
        Write-Host $msg -ForegroundColor DarkYellow
        "$timestamp,$ip,WinRM,SKIPPED,$msg" >> $logFile
        # jangan otomatis coba fallback PsExec di sini (opsional: pakai skrip PsExec terpisah)
    }
}

Write-Host "`nSelesai. Log: $logFile" -ForegroundColor Cyan
