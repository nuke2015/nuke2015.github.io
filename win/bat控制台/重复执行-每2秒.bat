@echo off

:start

echo %date%

choice /t 2 /d y /n >nul

goto start