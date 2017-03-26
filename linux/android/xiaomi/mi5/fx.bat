
fastboot %* erase bk12 2>&1
if not %ERRORLEVEL% == 0 exit /B 1
rem fastboot %* getvar soc_id 2>&1 | findstr /r /c:"^soc_id: *239" || echo Missmatching image and device in soc_id
rem fastboot %* getvar soc_id 2>&1 | findstr /r /c:"^soc_id: *239" || exit /B 1
fastboot %* flash modem %~dp0images\NON-HLOS.bin || @echo "Flash modem error" && exit /B 1
fastboot %* flash misc %~dp0images\misc.img || @echo "Flash misc error" && exit /B 1
fastboot %* flash system %~dp0images\system.img || @echo "Flash system error" && exit /B 1
fastboot %* flash recovery %~dp0images\recovery.img || @echo "Flash recovery error" && exit /B 1
fastboot %* flash splash  %~dp0images\splash.img || @echo "Flash splash error" && exit /B 1
fastboot %* erase boot || @echo "Erase boot error" && exit /B 1
fastboot %* erase switch || @echo "Erase switch error" && exit /B 1
fastboot %* erase mdtp || @echo "Erase mdtp error" && exit /B 1
fastboot %* flash boot %~dp0images\boot.img || @echo "Flash boot error" && exit /B 1
fastboot %* flash cust %~dp0images\cust.img || @echo "Flash cust error" && exit /B 1
fastboot %* reboot || @echo "Reboot error" && exit /B 1
pause

