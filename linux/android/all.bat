
fastboot %* flash partition %~dp0images\gpt_both0.bin || @echo "Flash tz error" && exit /B 1
fastboot %* flash tz %~dp0images\tz.mbn || @echo "Flash tz error" && exit /B 1
fastboot %* flash sbl1 %~dp0images\sbl1.mbn || @echo "Flash sbl1 error" && exit /B 1
fastboot %* flash rpm %~dp0images\rpm.mbn || @echo "Flash rpm error" && exit /B 1
fastboot %* flash aboot %~dp0images\emmc_appsboot.mbn || @echo "Flash emmc_appsboot error" && exit /B 1
fastboot %* flash hyp %~dp0images\hyp.mbn || @echo "Flash hyp error" && exit /B 1

fastboot %* flash tzbak %~dp0images\tz.mbn || @echo "Flash tzbak error" && exit /B 1
fastboot %* flash sbl1bak %~dp0images\sbl1.mbn || @echo "Flash sbl1bak error" && exit /B 1
fastboot %* flash rpmbak %~dp0images\rpm.mbn || @echo "Flash uboot rpmbak" && exit /B 1
fastboot %* flash abootbak %~dp0images\emmc_appsboot.mbn || @echo "Flash abootbak error" && exit /B 1
fastboot %* flash hypbak %~dp0images\hyp.mbn || @echo "Flash hypbak error" && exit /B 1

fastboot %* erase boot
fastboot %* flash modem %~dp0images\NON-HLOS.bin || @echo "Flash modem error" && exit /B 1
fastboot %* flash system %~dp0images\system.img || @echo "Flash system error" && exit /B 1
fastboot %* flash cache %~dp0images\cache.img || @echo "Flash cache error" && exit /B 1
fastboot %* flash userdata %~dp0images\userdata.img || @echo "Flash userdata error" && exit /B 1
fastboot %* flash recovery %~dp0images\recovery.img || @echo "Flash recovery error" && exit /B 1
fastboot %* flash boot %~dp0images\boot.img || @echo "Flash boot error" && exit /B 1
fastboot %* flash persist %~dp0images\persist.img || @echo "Flash persist error" && exit /B 1


fastboot %* flash sec %~dp0images\sec.dat || @echo "Flash sec error" && exit /B 1
fastboot %* flash splash %~dp0images\splash.img || @echo "Flash splash error" && exit /B 1

fastboot %* reboot


pause


