REM ����������ɾ���ܶ��޷�ɾ�����ļ�
REM  ʹ�÷��������½����ڶ�.bat ��Ȼ�󡡰���ɾ�����ļ��Ͻ�����
@echo off
:kill
set lj=\\?\%1
if %lj%==\\?\ goto exit
cacls %lj% /e /g everyone:F
del /f /a /q %lj%
rd /s /q %lj%
shift
goto kill
