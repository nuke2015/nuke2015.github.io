@echo off
:start
cls
color 1f
echo.
ECHO             Windows 垃圾卸载助手
echo.
ECHO                 深山红叶制作
ECHO     ====================================
ECHO     1. 自动卸载所有磁盘的全部垃圾类型
ECHO     2. 手工指定要清理的磁盘分区
ECHO     ------------------------------------
ECHO     Q. 放弃并退出
echo.
SET Choice=
SET /P Choice=    请选择要进行的操作（1/2/Q），然后按回车：
ECHO.
IF NOT '%Choice%'=='' SET Choice=%Choice:~0,1%
IF /I '%Choice%'=='1' GOTO all
IF /I '%Choice%'=='2' GOTO drv
IF /I '%Choice%'=='Q' GOTO end
GOTO Start

:all
ECHO     请不要关闭本窗口……
start /wait cleanmgr /sageset:99
start cleanmgr /SAGERUN:99
goto end

:drv
SET Choice=
SET /P Choice=    请选择要清理的磁盘分区：
echo.
ECHO     请不要关闭本窗口……
start /wait cleanmgr /sageset:99
start cleanmgr /d%choice%

:end
exit
