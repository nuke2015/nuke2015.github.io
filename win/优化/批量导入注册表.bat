@echo off
echo.
set root_path=%cd%
for /f %%i in ('dir /a /b %root_path%\*.reg') do regedit /s %root_path%\%%i
echo ע����ļ�������ɰ�������˳�...
pause>nul
exit
