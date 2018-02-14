echo 关闭系统索引服务
sc stop WMPNetworkSvc
ping -n 3 127.0.0.1
sc stop wsearch
sc config WMPNetworkSvc start= disabled
sc config wsearch start= disabled
echo 完成

ECHO 关闭家庭组
REM 据说能改善磁盘100%的情况
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\HomeGroup" /v "DisableHomeGroup" /d 1 /t REG_DWORD /f
sc stop HomeGroupListener
sc stop HomeGroupProvider
sc config HomeGroupListener start= disabled
sc config HomeGroupProvider start= disabled
echo 完成

ECHO 关闭休眠
powercfg -h off

ECHO 关闭Windows防火墙
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\WindowsFirewall\DomainProfile" /v "EnableFirewall" /d 0 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\WindowsFirewall\PrivateProfile" /v "EnableFirewall" /d 0 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\WindowsFirewall\PublicProfile" /v "EnableFirewall" /d 0 /t REG_DWORD /f
sc stop MpsSvc MpsSvc & sc config MpsSvc start=disabled
echo 完成


ECHO 关闭程序兼容性助手
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\AppCompat" /v "DisablePCA" /d 1 /t REG_DWORD /f
sc stop PcaSvc
sc config PcaSvc start= disabled
echo 完成

ECHO 禁止 Superfetch 服务（SSD必选）
sc stop SysMain
sc config "SysMain" start= disabled
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Memory ::Management\PrefetchParameters" /v "EnablePrefetcher" /d 0 /t REG_DWORD /f
echo 完成
 
ECHO 关闭开机画面（GUI引导可以提高一点开机速度）
bcdedit /set quietboot on
echo 完成

ECHO 设置系统自带截屏保存到桌面
rd /s /q %userprofile%\pictures\Screenshots
mklink /j %userprofile%\pictures\Screenshots %userprofile%\desktop

ECHO 关闭磁盘碎片整理计划
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\Defrag\ScheduledDefrag"
echo 完成
 
ECHO 禁用系统日志和内存转储（禁止自动重启）
::reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\CrashControl" /v "LogEvent" /d 0 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\CrashControl" /v "AutoReboot" /d 0 /t REG_dword /f
::reg add "HKEY_LOCAL_MACHINE\SYSTEM\ControlSet001\Control\CrashControl" /v "CrashDumpEnabled" /d 0 /t REG_dword /f
::reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Windows Error Reporting" /v "LoggingDisabled" /d 1 /t REG_dword /f
::reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\Windows Error Reporting" /v "Disabled" /d 1 /t REG_dword /f
echo 完成
 
ECHO 禁用疑难解答和系统诊断以及NTFS快捷方式跟踪服务
sc stop WdiSystemHost
sc stop WdiServiceHost
sc stop DPS
sc stop DiagTrack
sc config DPS start= disabled
sc config WdiServiceHost start= disabled
sc config WdiSystemHost start= disabled
sc config DiagTrack start= disabled
echo 完成
 
ECHO 禁用无用服务
sc config BthHFSrv start= disabled
sc config LanmanWorkstation start= disabled
sc config spectrum start= disabled
sc config bthserv start= disabled
sc config OneSyncSvc_34c8c start= disabled
sc config RetailDemo start= disabled
sc config pla start= disabled
sc config ALG start= disabled
sc config HvHost start= disabled
sc config NcbService start= disabled
sc config LanmanServer start= disabled
sc config LicenseManager start= disabled
sc config Browser start= disabled
sc config CscService start= disabled
sc config BITS start= disabled
sc config ShellHWDetection start= disabled
sc config RasAuto start= disabled
sc config RasMan start= disabled
sc config RpcSs start= disabled
sc config seclogon start= disabled
sc config SSDPSRV start= disabled

ECHO 禁用NTFS快捷方式跟踪和IPV6服务
sc stop iphlpsvc
sc stop TrkWks
sc config TrkWks start= disabled
sc config iphlpsvc start= disabled
echo 完成

ECHO 禁用提示开始防火墙
sc config wscsvc start= disabled
echo 完成
 
ECHO 禁用任务计划程序自启项
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\Windows Error Reporting\QueueReporting"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\SkyDrive\Routine Maintenance Task"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\SkyDrive\Idle Sync Maintenance Task"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\DiskDiagnostic\Microsoft-Windows-DiskDiagnosticResolver"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\DiskDiagnostic\Microsoft-Windows-DiskDiagnosticDataCollector"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\Diagnosis\Scheduled"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\Defrag\ScheduledDefrag"
SCHTASKS /Change /DISABLE /TN "\GoogleUpdateTaskMachineUA"
SCHTASKS /Change /DISABLE /TN "\GoogleUpdateTaskMachineCore"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Office\OfficeTelemetryAgentFallBack"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Office\OfficeTelemetryAgentLogOn"
SCHTASKS /Change /DISABLE /TN "\AdobeAAMUpdater-1.0-%computername%-%username%"
SCHTASKS /Change /DISABLE /TN "\Microsoft\Office\Office 15 Subscription Heartbeat"
echo 完成
 
ECHO IE11开启企业模式
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /v SiteList /d "HKCU\Software\policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /t reg_sz /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /v Enable /d "" /t reg_sz /f
echo 完成

ECHO 启动电源计划“高性能”
powercfg.exe -setactive 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c
echo 完成

ECHO 关闭显示器前等待时间: 从不
powercfg -change -monitor-timeout-ac 0
powercfg -change -monitor-timeout-dc 0
echo 完成

ECHO 关闭不必要的视觉动画效果
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\DWM" /v "DisallowAnimations" /d 1 /t REG_dword /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "TurnOffSPIAnimations" /d 1 /t REG_dword /f
reg add "HKEY_CURRENT_USER\Control Panel\Desktop\WindowMetrics" /v "MinAnimate" /d 0 /t REG_SZ /f
echo 完成

ECHO 关闭不需要的视觉效果
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\VisualEffects" /v "VisualFXSetting" /d 3 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\DWM" /v "AlwaysHibernateThumbnails" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v "FontSmoothing" /d 2 /t REG_SZ /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\DWM" /v "EnableAeroPeek" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "TaskbarAnimations" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v "DragFullWindows" /d 1 /t REG_SZ /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "ListviewAlphaSelect" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "IconsOnly" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "ListviewShadow" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Control Panel\Desktop\WindowMetrics" /v "MinAnimate" /d 0 /t REG_SZ /f
reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v "UserPreferencesMask" /d "9012038010000000" /t REG_BINARY /f
echo 完成

ECHO 清除右键多余菜单
regsvr32 /u /s igfxpph.dll
reg delete HKEY_CLASSES_ROOT\Directory\Background\shellex\ContextMenuHandlers /f
reg add HKEY_CLASSES_ROOT\Directory\Background\shellex\ContextMenuHandlers\new /ve /d {D969A300-E7FF-11d0-A93B-00A0C90F2719}
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /v HotKeysCmds /f
reg delete HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run /v IgfxTray /f
echo 完成
 
taskkill /f /im explorer.exe
start %systemroot%\explorer
 
echo 完毕！
echo.