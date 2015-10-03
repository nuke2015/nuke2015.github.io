@echo off
echo ÅúÁ¿ÉèÖÃ¸÷ÖÖÀ©Õ¹ÃûµÄ´ò¿ª·½Ê½
rem http://github.com/nuke2015
set tmp_reg=%cd%\tmp.ini
set Application=sublime_text.exe
set FileExts=.ini .txt .cnf .conf .css .log .cfg .xml .php .asp .java .js .css .htm .sh .py .go




rem 开始处理
echo %Application%
echo %FileExts%
del %tmp_reg% > nul
echo Windows Registry Editor Version 5.00>%tmp_reg%
echo.>>%tmp_reg%
for %%i in (%FileExts%) do (
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i]>>%tmp_reg%
	echo "Application"="Applications\\%Application%">>%tmp_reg%
	echo.>>%tmp_reg%
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i\OpenWithList]>>%tmp_reg%
	echo "a"="Applications\\notepad.exe">>%tmp_reg%
	echo "b"="Applications\\gvim.exe">>%tmp_reg%
	echo "c"="Applications\\notepad++.exe">>%tmp_reg%
	echo "d"="Applications\\%Application%">>%tmp_reg%
	echo "MRUList"="dcba">>%tmp_reg%
	echo.>>%tmp_reg%
	echo [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\%%i\UserChoice]>>%tmp_reg%
	echo "Progid"="Applications\\%Application%">>%tmp_reg%
	echo.>>%tmp_reg%
)

regedit /s %temp%\tmp.ini
taskkill /im explorer.exe /f > nul
start C:\Windows\explorer.exe
echo done.
pause
