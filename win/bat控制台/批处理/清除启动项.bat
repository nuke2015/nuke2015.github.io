@echo OFF
color f1
title 清除多余的启动项目
@echo.
@echo.                          说  明
@echo --------------------------------------------------------------
@echo 自动清理多余的启动项目，仅保留输入法(ctfmon和ring3.sys)。
@echo 目的是减少不必要的资源占用，使系统运行顺畅。
@echo.
PAUSE
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /va /f
reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /va /f
reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /v ctfmon.exe /d C:\WINDOWS\system32\ctfmon.exe
reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /v ring3.sys /d C:\WINDOWS\system32\ring3.sys
del "C:\Documents and Settings\All Users\「开始」菜单\程序\启动\*.*" /a /q /f
del "C:\Documents and Settings\Default User\「开始」菜单\程序\启动\*.*" /a /q /f
del "%userprofile%\「开始」菜单\程序\启动\*.*" /q /f
rd "C:\Documents and Settings\Default User\「开始」菜单\程序\启动\ /s /q
rd "%userprofile%\「开始」菜单\程序\启动\*.*"  /s /q
rd "C:\Documents and Settings\Default User\「开始」菜单\程序\启动\ /s /q
echo 操作结束,感谢使用
echo.
pause
