@echo off
color a 
echo.
echo.
set name=锋速网络
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Control\ComputerName\ActiveComputerName" /v ComputerName /t reg_sz /d %name% /f
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Tcpip\Parameters" /v "NV Hostname" /t reg_sz /d %name% /f 
reg add "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Tcpip\Parameters" /v Hostname /t reg_sz /d %name% /f 
cls
echo 现在自动设置IP地址
@echo off

set slection1=10.206.30.5
netsh interface ip set address name="本地连接" source=static addr=%slection1% mask=255.255.255.0

set slection2=10.206.30.254
netsh interface ip set address name="本地连接" gateway=%slection2% gwmetric=0


set slection3=202.96.128.86
netsh interface ip set dns name="本地连接" source=static addr=%slection3% register=PRIMARY


set slection4=202.96.128.166
netsh interface ip add dns name="本地连接" addr=%slection4%
netsh interface ip set wins name="本地连接" source=static addr=none
@echo IP设置成功啦,请关闭本软件
pause 


