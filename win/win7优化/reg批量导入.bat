@echo off
echo.
set root_path=%cd%
for /f %%i in ('dir /a /b %root_path%\reg\*.reg') do regedit /s %root_path%\reg\%%i
echo ע����ļ�������ɰ�������˳�...
pause>nul
exit
