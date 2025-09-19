
sc stop NgrokService 
sc delete NgrokService 

cd /D C:\laragon\www\siakad\executor\nssm\win64
nssm install NgrokService "C:\laragon\www\siakad\executor\ngrok\ngrok_akses.exe"
