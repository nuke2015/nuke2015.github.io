@echo off
echo FileExts setting batch with sublime
rem http://github.com/nuke2015
set tmp_reg=%temp%\tmp.ini
set Application=gvim.exe
set FileExts=.ini .txt .cnf .conf .css .log .cfg .xml .php .asp .java .js .css .htm .sh .py .go



rem do it now!
echo %Application%
echo %FileExts%
del %tmp_reg% > nul
echo Windows Registry Editor Version 5.00>%tmp_reg%
echo.>>%tmp_reg%
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
taskkill /im explorer.exe /f > nul
start C:\Windows\explorer.exe
echo done.
pause
