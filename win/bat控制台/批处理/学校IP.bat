@echo off
color a 
echo.
echo.
set name=��������
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Control\ComputerName\ActiveComputerName" /v ComputerName /t reg_sz /d %name% /f
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Tcpip\Parameters" /v "NV Hostname" /t reg_sz /d %name% /f 
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Tcpip\Parameters" /v Hostname /t reg_sz /d %name% /f 
cls
echo �����Զ�����IP��ַ
@echo off

set slection1=10.206.30.5
netsh interface ip set address name="��������" source=static addr=%slection1% mask=255.255.255.0

set slection2=10.206.30.254
netsh interface ip set address name="��������" gateway=%slection2% gwmetric=0


set slection3=202.96.128.86
netsh interface ip set dns name="��������" source=static addr=%slection3% register=PRIMARY


set slection4=202.96.128.166
netsh interface ip add dns name="��������" addr=%slection4%
netsh interface ip set wins name="��������" source=static addr=none
@echo IP���óɹ���,��رձ����
pause 


