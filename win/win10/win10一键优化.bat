
@ECHO off
TITLE Windows 10 一键优化工具
COLOR 0a
 
set TempFile_Name=%SystemRoot%\System32\BatTestUACin_SysRt%Random%.batemp
( echo "BAT Test UAC in Temp" >%TempFile_Name% ) 1>nul 2>nul
if exist %TempFile_Name% (
del %TempFile_Name% 1>nul 2>nul
GOTO setting
) else (
GOTO admin
)
 
:setting
echo.
echo.
echo.
ECHO                            按任意键开始一键优化！
pause>nul
 
 
echo 优化开始
 
echo 正在停止索引服务
sc stop WMPNetworkSvc
ping -n 3 127.0.0.1>nul
sc stop wsearch
sc config WMPNetworkSvc start= disabled
sc config wsearch start= disabled
echo 完成
 
 
ECHO 禁止window发送错误报告
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\Windows Error Reporting" /v "Disabled" /d 1 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\PCHealth\ErrorReporting" /v "DoReport" /d 0 /t REG_DWORD /f
echo 完成
 
ECHO 禁用"最近使用的项目"
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "Start_TrackProgs" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced" /v "Start_TrackDocs" /d 0 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Classes\Local Settings\Software\Microsoft\Windows\CurrentVersion\TrayNotify" /v "IconStreams" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Classes\Local Settings\Software\Microsoft\Windows\CurrentVersion\TrayNotify" /v "PastIconsStream" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "NoRecentDocsHistory" /d 1 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "NoInstrumentation" /d 1 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Explorer" /v "DisableSearchBoxSuggestions" /d 1 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Explorer" /v "DisableSearchHistory" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 关闭Windows Defender
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows Defender" /v "DisableAntiSpyware" /d 1 /t REG_DWORD /f
echo 完成
 
 
ECHO 检查更新而不自动下载更新
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU" /v "NoAutoUpdate" /d 0 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU" /v "AUOptions" /d 2 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU" /v "ScheduledInstallDay" /d 0 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU" /v "ScheduledInstallTime" /d 3 /t REG_DWORD /f
echo 完成
 
ECHO 关闭系统保护
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\SystemRestore" /v "RPSessionInterval" /d 0 /t REG_DWORD /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\SPP\Clients" /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows NT\SystemRestore" /v "DisableSR" /d 1 /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\Installer" /v "LimitSystemRestoreCheckpointing" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 关闭用户账户控制(UAC)
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System" /v "ConsentPromptBehaviorAdmin" /d 0 /t REG_DWORD /f
echo 完成
 
ECHO 移除右键菜单中的SkyDrive Pro
reg delete "HKEY_CLASSES_ROOT\AllFilesystemObjects\shell\SPFS.ContextMenu" /f
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
 
ECHO 禁止运行计算机自动维护计划
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\ScheduledDiagnostics" /v "EnabledExecution" /d 0 /t REG_DWORD /f
echo 完成

ECHO 关闭程序兼容性助手
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\AppCompat" /v "DisablePCA" /d 1 /t REG_DWORD /f
sc stop PcaSvc
sc config PcaSvc start= disabled
echo 完成
 
ECHO 禁止一联网就打开浏览器
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\NetworkConnectivityStatusIndicator" /v "NoActiveProbe" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 删除“这台电脑”6个文件夹
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{088e3905-0323-4b02-9826-5d99428e115f}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{24ad3ad4-a569-4530-98e1-ab02f9417aa8}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{3dfdf296-dbec-4fb4-81d1-6a3438bcf4de}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{d3162b92-9365-467a-956b-92703aca08af}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{f86fa3ab-70d2-4fc7-9c99-fcbf05467f3a}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{B4BFCC3A-DB2C-424C-B029-7FE99A87C641}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{088e3905-0323-4b02-9826-5d99428e115f}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{24ad3ad4-a569-4530-98e1-ab02f9417aa8}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{3dfdf296-dbec-4fb4-81d1-6a3438bcf4de}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{d3162b92-9365-467a-956b-92703aca08af}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{f86fa3ab-70d2-4fc7-9c99-fcbf05467f3a}" /f
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Wow6432Node\Microsoft\Windows\CurrentVersion\Explorer\MyComputer\NameSpace\{B4BFCC3A-DB2C-424C-B029-7FE99A87C641}" /f
echo 完成
 
ECHO 显示受保护的系统文件
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Advanced\Folder\Hidden\SHOWALL" /v "CheckedValue" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 桌面显示“这台电脑”
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v "{20D04FE0-3AEA-1069-A2D8-08002B30309D}" /d 0 /t REG_DWORD /f
echo 完成
 
ECHO 启用IE增强保护模式
reg add "HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main" /v "Isolation" /d "PMEM" /t REG_SZ /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main" /v "Isolation64Bit" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 将临时文件夹移动E盘
reg add "HKEY_CURRENT_USER\Environment" /v "TMP" /d "E:\userdata\temp" /t REG_EXPAND_SZ /f
reg add "HKEY_CURRENT_USER\Environment" /v "TEMP" /d "E:\userdata\temp" /t REG_EXPAND_SZ /f
echo 完成
 
ECHO 关闭家庭组
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\HomeGroup" /v "DisableHomeGroup" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 延迟启动 Superfetch 服务
sc config "SysMain" start= delayed-auto
echo 完成
 
ECHO 关闭开机画面（GUI引导）
bcdedit /set quietboot on
echo 完成
 
ECHO 关闭 IPv6
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Services\TCPIP6\Parameters" /v "DisabledComponents" /d 255 /t REG_DWORD /f
echo 完成
 
ECHO 关闭客户体验改善计划
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\SQMClient\Windows" /v "CEIPEnable" /d 0 /t REG_DWORD /f
echo 完成
 
ECHO 隐藏操作中心任务栏托盘
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "HideSCAHealth" /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 关闭自动播放
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "NoDriveTypeAutoRun" /d 255 /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "NoDriveTypeAutoRun" /d 255 /t REG_DWORD /f
echo 完成
 
ECHO 删除回收站右键固定到开始屏幕
reg delete "HKEY_LOCAL_MACHINE\SOFTWARE\Classes\Folder\shellex\ContextMenuHandlers\PintoStartScreen" /f
echo 完成
 
ECHO 关闭Smartscreen应用筛选器
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer" /v "SmartScreenEnabled" /d off /t REG_SZ /f
echo 完成
 
ECHO 关机时强制杀后台不等待
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control" /v "WaitToKillServiceTimeout" /d 0 /t REG_SZ /f
echo 完成
 
ECHO 关闭远程协助
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows NT\Terminal Services" /v "fAllowToGetHelp" /d 0 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows NT\Terminal Services" /v "fAllowUnsolicited" /d 0 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows NT\Terminal Services" /v "fDenyTSConnections" /d 1 /t REG_dword /f
echo 完成
 
ECHO 直接删除文件不进入回收站
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "NoRecycleFiles" /d 1 /t REG_dword /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\HideDesktopIcons\NewStartPanel" /v "{645FF040-5081-101B-9F08-00AA002F954E}" /d 1 /t REG_dword /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer" /v "ConfirmFileDelete" /d 1 /t REG_dword /f
echo 完成
 
ECHO 任务栏日期显示“星期几”
reg add "HKEY_CURRENT_USER\Control Panel\International" /v "sLongDate" /d "yyyy'年'M'月'd'日', dddd" /t REG_SZ /f
reg add "HKEY_CURRENT_USER\Control Panel\International" /v "sShortDate" /d "yyyy/M/d/ddd" /t REG_SZ /f
echo 完成
 
ECHO 设置系统自带截屏保存到桌面
rd /s /q %userprofile%\pictures\Screenshots
mklink /j %userprofile%\pictures\Screenshots %userprofile%\desktop
echo 完成
 
ECHO 关闭磁盘碎片整理计划
SCHTASKS /Change /DISABLE /TN "\Microsoft\Windows\Defrag\ScheduledDefrag"
echo 完成
 
ECHO 禁用系统日志和内存转储
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\CrashControl" /v "LogEvent" /d 0 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\CrashControl" /v "AutoReboot" /d 0 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SYSTEM\ControlSet001\Control\CrashControl" /v "CrashDumpEnabled" /d 0 /t REG_dword /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Windows Error Reporting" /v "LoggingDisabled" /d 1 /t REG_dword /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\Windows Error Reporting" /v "Disabled" /d 1 /t REG_dword /f
echo 完成
 
ECHO 禁用疑难解答和系统诊断服务
sc stop WdiSystemHost
sc stop WdiServiceHost
sc stop DPS
sc config DPS start= disabled
sc config WdiServiceHost start= disabled
sc config WdiSystemHost start= disabled
echo 完成
 
ECHO 去除快捷方式小箭头和后缀
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Shell Icons" /v 29 /d "%systemroot%\system32\imageres.dll,197" /t reg_sz /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer" /v link /d "00000000" /t REG_BINARY /f
del "%userprofile%\AppData\Local\iconcache.db" /f /q
echo 完成
 
ECHO 去除UAC小盾牌
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Shell Icons" /v 77 /d "%systemroot%\system32\imageres.dll,197" /t reg_sz /f
del "%userprofile%\AppData\Local\iconcache.db" /f /q
echo 完成
 
ECHO IE11开启企业模式
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /v SiteList /d "HKCU\Software\policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /t reg_sz /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Main\EnterpriseMode" /v Enable /d "" /t reg_sz /f
echo 完成
 
:admin1
ECHO 启用Administrator账户
net user administrator /active:yes
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System" /v FilterAdministratorToken /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 鼠标指向右上角不显示超级按钮
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\EdgeUI" /v DisableCharms /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 开始屏幕自动显示"应用"视图
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Explorer" /v ShowAppsViewOnStart /d 1 /t REG_DWORD /f
echo 完成
 
ECHO 登录显示桌面而非开始屏幕
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Windows\Explorer" /v GoToDesktopOnSignIn /d 1 /t REG_DWORD /f
echo 完成
 
echo 打开IE请勿追踪功能(Do Not Track)
reg add "HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main" /v "DoNotTrack" /d "1" /t REG_DWORD /f
taskkill /f /im iexplore.exe
ECHO 完成
 
gpupdate /force
taskkill /f /im explorer.exe
start %systemroot%\explorer
 
COLOR 0a
echo.
echo.
echo.
echo.
echo.
echo.
echo.
echo.
echo                          恭喜！全部优化操作已经执行完毕
echo.
echo.
echo.
echo                              请自行向上翻看操作记录
echo.
echo.
echo.
echo.
echo.
echo.
echo.
echo.
echo.
pause>nul

 
:admin
CLS
COLOR 0a
MODE con: COLS=30 LINES=8
ECHO 操作失败。
echo 请右键“以管理员身份运行”
ECHO 按任意键退出...
PAUSE >nul
exit
