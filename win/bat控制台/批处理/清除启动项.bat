@echo OFF
color f1
title ��������������Ŀ
@echo.
@echo.                          ˵  ��
@echo --------------------------------------------------------------
@echo �Զ���������������Ŀ�����������뷨(ctfmon��ring3.sys)��
@echo Ŀ���Ǽ��ٲ���Ҫ����Դռ�ã�ʹϵͳ����˳����
@echo.
PAUSE
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /va /f
reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /va /f
reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /v ctfmon.exe /d C:\WINDOWS\system32\ctfmon.exe
reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run /v ring3.sys /d C:\WINDOWS\system32\ring3.sys
del "C:\Documents and Settings\All Users\����ʼ���˵�\����\����\*.*" /a /q /f
del "C:\Documents and Settings\Default User\����ʼ���˵�\����\����\*.*" /a /q /f
del "%userprofile%\����ʼ���˵�\����\����\*.*" /q /f
rd "C:\Documents and Settings\Default User\����ʼ���˵�\����\����\ /s /q
rd "%userprofile%\����ʼ���˵�\����\����\*.*"  /s /q
rd "C:\Documents and Settings\Default User\����ʼ���˵�\����\����\ /s /q
echo ��������,��лʹ��
echo.
pause
