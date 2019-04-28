@echo off

cd\&cls&color 0a

echo.&echo.

ECHO .桌面上显示计算机图标

reg add "HKCU\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v {20D04FE0-3AEA-1069-A2D8-08002B30309D} /t REG_DWORD /d 0 /f 2>nul

echo.&ECHO .桌面上显示回收站图标

reg add "HKCU\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v {645FF040-5081-101B-9F08-00AA002F954E} /t REG_DWORD /d 0 /f 2>nul

echo.&ECHO .桌面上显示网络图标

reg add "HKCU\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v {F02C1A0D-BE21-4350-88B0-7367FC96EF3C} /t REG_DWORD /d 0 /f 2>nul

reg add "HKCU\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v {208D2C60-3AEA-1069-A2D7-08002B30309D} /t REG_DWORD /d 0 /f 2>nul

echo.&echo.&echo 处理完成。若桌面无图标出现，请按F5键刷新桌面

pause