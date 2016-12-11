@echo off
echo.
set root_path=%cd%
for /f %%i in ('dir /a /b %root_path%\reg\*.reg') do regedit /s %root_path%\reg\%%i
echo 注册表文件导入完成按任意键退出...
pause>nul
exit
