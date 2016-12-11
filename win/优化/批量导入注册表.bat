@echo off
echo.
set root_path=%cd%
for /f %%i in ('dir /a /b %root_path%\*.reg') do regedit /s %root_path%\%%i
echo 注册表文件导入完成按任意键退出...
pause>nul
exit
