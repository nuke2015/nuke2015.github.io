echo "Fastboot Tool Ver 7.0"

fastboot %* erase boot
fastboot %* flash modem %~dp0images\NON-HLOS.bin || @echo "Flash modem error" && exit /B 1
fastboot %* flash system %~dp0images\system.img || @echo "Flash system error" && exit /B 1
fastboot %* flash boot %~dp0images\boot.img || @echo "Flash boot error" && exit /B 1

pause