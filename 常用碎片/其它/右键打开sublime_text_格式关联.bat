@echo off
echo FileExts setting batch with sublime
rem http://github.com/nuke2015
set tmp_reg=%tmp%\reg.ini
set Application=sublime_text.exe
set Application_command=D:\\working\\Sublime\\sublime_text.exe
set FileExts=.ini .txt .cnf .conf .css .log .cfg .xml .php .asp .java .js .css .htm .sh .py .go


rem do it now!
echo %Application%
echo %FileExts%
del %tmp_reg% > nul

rem  Application setting;

echo Windows Registry Editor Version 5.00>%tmp_reg%
echo.>>%tmp_reg%
echo [HKEY_CLASSES_ROOT\*\shell\%Application%]>>%tmp_reg%
echo @="open with %Application%">>%tmp_reg%
echo [HKEY_CLASSES_ROOT\*\shell\%Application%\command]>>%tmp_reg%
echo @="%Application_command% %%1">>%tmp_reg%
echo.>>%tmp_reg%
echo [HKEY_CLASSES_ROOT\Folder\shell\%Application%]>>%tmp_reg%
echo @="Sublime">>%tmp_reg%
echo [HKEY_CLASSES_ROOT\Folder\shell\%Application%\command]>>%tmp_reg%
echo @="%Application_command% %%1">>%tmp_reg%
echo.>>%tmp_reg%
echo [HKEY_CURRENT_USER\Software\Classes\Applications\%Application%]>>%tmp_reg%
echo [HKEY_CURRENT_USER\Software\Classes\Applications\%Application%\shell\open\command]>>%tmp_reg%
echo @="%Application_command% %%1">>%tmp_reg%

rem FileExts setting;
for %%i in (%FileExts%) do (
	echo [-HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i]>>%tmp_reg%
	echo.>>%tmp_reg%
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i]>>%tmp_reg%
	echo "Application"="Applications\\%Application%">>%tmp_reg%
	echo.>>%tmp_reg%
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i\OpenWithList]>>%tmp_reg%
	echo "a"="notepad.exe">>%tmp_reg%
	echo "b"="gvim.exe">>%tmp_reg%
	echo "c"="notepad++.exe">>%tmp_reg%
	echo "d"="%Application%">>%tmp_reg%
	echo "MRUList"="dcba">>%tmp_reg%
	echo.>>%tmp_reg%
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i\UserChoice]>>%tmp_reg%
	echo "Progid"="Applications\\%Application%">>%tmp_reg%
	echo.>>%tmp_reg%
)

regedit /s %tmp_reg%
echo done.
pause
