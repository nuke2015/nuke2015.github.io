echo "Fastboot Tool Ver 7.0"

fastboot %* erase boot
fastboot %* flash boot %~dp0images\boot.img || @echo "Flash boot error" && exit /B 1
fastboot %* flash recovery %~dp0images\recovery.img || @echo "Flash recovery error" && exit /B 1

pause