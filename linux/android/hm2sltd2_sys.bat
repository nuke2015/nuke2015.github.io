echo "Fastboot Tool Ver 7.0"



fastboot %* flash boot %~dp0images\boot.img
fastboot %* flash cache %~dp0images\cache.img

pause

fastboot %* flash system %~dp0images\system.img

fastboot %* reboot

pause

