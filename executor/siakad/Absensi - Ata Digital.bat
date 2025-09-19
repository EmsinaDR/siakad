@echo off
"C:\Program Files\Google\Chrome\Application\chrome.exe" ^
  --kiosk --start-fullscreen http://localhost ^
  --user-data-dir="C:\chrome-kiosk-profile" ^
  --no-first-run ^
  --disable-infobars ^
  --disable-translate ^
--lang=id ^
  --disable-features=TranslateUI
exit
