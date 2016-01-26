REM 它可以批量删除很多无法删除的文件
REM  使用方法就是新建　黑洞.bat ，然后　把欲删除的文件拖进来～
@echo off
:kill
set lj=\\?\%1
if %lj%==\\?\ goto exit
cacls %lj% /e /g everyone:F
del /f /a /q %lj%
rd /s /q %lj%
shift
goto kill
