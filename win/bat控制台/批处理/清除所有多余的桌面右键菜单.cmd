@ ECHO OFF
title 清除所有多余的桌面右键菜单
color 1a
@ ECHO.
@ ECHO.
@ ECHO.                              说  明
@ ECHO -----------------------------------------------------------------------
@ ECHO 很多显卡在装了驱动之后，桌面右键会多出一项或多项菜单，这些功能并不实用，
@ ECHO 还会拖慢右键的弹出速度，我们最好清除它。---寒岩傲松电脑工作室
PAUSE

regsvr32 /u /s igfxpph.dll
reg delete HKEY_CLASSES_ROOT\Directory\Background\shellex\ContextMenuHandlers /f
reg add HKEY_CLASSES_ROOT\Directory\Background\shellex\ContextMenuHandlers\new /ve /d {D969A300-E7FF-11d0-A93B-00A0C90F2719}
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /v HotKeysCmds /f
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /v IgfxTray /f
