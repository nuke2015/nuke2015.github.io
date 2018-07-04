@echo off
set /p vi=请输入你想删除的文件:
setlocal enabledelayedexpansion
for /f "delims=\" %%i in ('fsutil fsinfo drives^|find /v ""') do (
    set var=%%i
    set drive=!var:~-2!
    fsutil fsinfo drivetype !drive!|find "固定">nul && del /a /f /s /q !drive!\autorun.inf
    fsutil fsinfo drivetype !drive!|find "固定">nul && rd /q /s !drive!\autorun.inf
)
@echo off
setlocal enabledelayedexpansion
for /f "delims=\" %%i in ('fsutil fsinfo drives^|find /v ""') do (
    set var=%%i
    set drive=!var:~-2!
    fsutil fsinfo drivetype !drive!|find "固定">nul && del /a /f /s /q !drive!\%vi%
    fsutil fsinfo drivetype !drive!|find "固定">nul && del /a /f /s /q !drive!\%vi%.exe
)
pause