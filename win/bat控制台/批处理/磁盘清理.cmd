@echo off
:start
cls
color 1f
echo.
ECHO             Windows ����ж������
echo.
ECHO                 ��ɽ��Ҷ����
ECHO     ====================================
ECHO     1. �Զ�ж�����д��̵�ȫ����������
ECHO     2. �ֹ�ָ��Ҫ����Ĵ��̷���
ECHO     ------------------------------------
ECHO     Q. �������˳�
echo.
SET Choice=
SET /P Choice=    ��ѡ��Ҫ���еĲ�����1/2/Q����Ȼ�󰴻س���
ECHO.
IF NOT '%Choice%'=='' SET Choice=%Choice:~0,1%
IF /I '%Choice%'=='1' GOTO all
IF /I '%Choice%'=='2' GOTO drv
IF /I '%Choice%'=='Q' GOTO end
GOTO Start

:all
ECHO     �벻Ҫ�رձ����ڡ���
start /wait cleanmgr /sageset:99
start cleanmgr /SAGERUN:99
goto end

:drv
SET Choice=
SET /P Choice=    ��ѡ��Ҫ����Ĵ��̷�����
echo.
ECHO     �벻Ҫ�رձ����ڡ���
start /wait cleanmgr /sageset:99
start cleanmgr /d%choice%

:end
exit
