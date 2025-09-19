Set WshShell = CreateObject("WScript.Shell")

' === Backup Database ===
WshShell.Run """" & "C:\laragon_instaler\www\siakad\executor\siakad\BackUp Database.bat" & """", 0, False

' === Restart Service ===
WshShell.Run """" & "C:\laragon\www\siakad\executor\nssm\win64\restart_services.bat" & """", 0, False

' === Bersihin temp folder ===
'WshShell.Run """" & "C:\laragon_instaler\www\siakad\executor\siakad\Cleanup Temp.bat" & """", 0, False

' === Sync data ke server ===
'WshShell.Run """" & "D:\script\AutoSync.bat" & """", 0, False
