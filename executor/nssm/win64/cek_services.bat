@echo off
cd /d C:\laragon\www\siakad\executor\nssm\win64

sc query myNodeserver
sc query LaravelSchedule
sc query NgrokService