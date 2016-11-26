
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
echo.
ECHO                              一键优化马上开始！
echo.
echo                          请先退出360等安全防护软件，并以管理员运行
echo.
echo                        请不要理会执行过程中的“失败”
echo.
ECHO                              无法恢复所做更改！
echo.
echo                              请不要中途关闭哦！
echo.
echo                              不然你懂的......
echo.
ECHO                              你想好了吗？
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
 
 
ECHO 启动电源计划“高性能”
powercfg.exe -setactive 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c
echo 完成
 
rem 先换成其他电源计划
powercfg.exe -setactive a1841308-3541-4fab-bc81-f71556f20b4a
 
ECHO 按电源按钮时：关机
rem powercfg -setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 4f971e89-eebd-4455-a8de-9e59040e7347 7648efa3-dd9c-4e3e-b566-50f929386280 3
rem powercfg -setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 4f971e89-eebd-4455-a8de-9e59040e7347 7648efa3-dd9c-4e3e-b566-50f929386280 3
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\7648EFA3-DD9C-4E3E-B566-50F929386280" /v "ACSettingIndex" /d "3" /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\7648EFA3-DD9C-4E3E-B566-50F929386280" /v "DCSettingIndex" /d "3" /t REG_DWORD /f
echo 完成
 
ECHO 关闭盖子时:不采取任何操作
rem powercfg -setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 4f971e89-eebd-4455-a8de-9e59040e7347 5ca83367-6e45-459f-a27b-476b1d01c936 0
rem powercfg -setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 4f971e89-eebd-4455-a8de-9e59040e7347 5ca83367-6e45-459f-a27b-476b1d01c936 0
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\5CA83367-6E45-459F-A27B-476B1D01C936" /v "ACSettingIndex" /d "0" /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\5CA83367-6E45-459F-A27B-476B1D01C936" /v "DCSettingIndex" /d "0" /t REG_DWORD /f
ECHO 完成
 
ECHO 关闭显示器前等待时间:10分钟
powercfg -setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 7516b95f-f776-4464-8c53-06167f40cc99 3c0bc021-c8a8-4e07-a973-6b14cbcb2b7e 600
powercfg -setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 7516b95f-f776-4464-8c53-06167f40cc99 3c0bc021-c8a8-4e07-a973-6b14cbcb2b7e 600
rem add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\3C0BC021-C8A8-4E07-A973-6B14CBCB2B7E" /v "ACSettingIndex" /d "600" /t REG_DWORD /f
rem add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\3C0BC021-C8A8-4E07-A973-6B14CBCB2B7E" /v "DCSettingIndex" /d "600" /t REG_DWORD /f
echo 完成
 
echo 计算机进入睡眠状态前等待时间：永不
powercfg -setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 29f6c1db-86da-48c5-9fdb-f2b67b1f44da 0
powercfg -setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 29f6c1db-86da-48c5-9fdb-f2b67b1f44da 0
echo 完成
 
echo 显示器亮度值：最低
powercfg -setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 7516b95f-f776-4464-8c53-06167f40cc99 aded5e82-b909-4619-9949-f5d71dac0bcb 0
powercfg -setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 7516b95f-f776-4464-8c53-06167f40cc99 aded5e82-b909-4619-9949-f5d71dac0bcb 0
echo 完成
 
ECHO 唤醒时需要密码
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\0e796bdb-100d-47d6-a2d5-f7d2daa51f51" /v "ACSettingIndex" /d "1" /t REG_DWORD /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\0e796bdb-100d-47d6-a2d5-f7d2daa51f51" /v "DCSettingIndex" /d "1" /t REG_DWORD /f
echo 完成
 
echo 关闭硬盘前等待时间：不关闭
powercfg /setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 0012ee47-9041-4b5d-9b77-535fba8b1442 6738e2c4-e8a5-4a42-b16a-e040e769756e 0
powercfg /setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 0012ee47-9041-4b5d-9b77-535fba8b1442 6738e2c4-e8a5-4a42-b16a-e040e769756e 0
rem reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\6738E2C4-E8A5-4A42-B16A-E040E769756E" /v "ACSettingIndex" /d "0" /t REG_DWORD /f
rem reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\6738E2C4-E8A5-4A42-B16A-E040E769756E" /v "DCSettingIndex" /d "0" /t REG_DWORD /f
echo 完成
 
ECHO 启用混合睡眠
powercfg /setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 94ac6d29-73ce-41a6-809f-6363ba21b47e 1
powercfg /setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 94ac6d29-73ce-41a6-809f-6363ba21b47e 1
rem reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\94ac6d29-73ce-41a6-809f-6363ba21b47e" /v "ACSettingIndex" /d "0" /t REG_DWORD /f
rem reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings\94ac6d29-73ce-41a6-809f-6363ba21b47e" /v "DCSettingIndex" /d "0" /t REG_DWORD /f
echo 完成
 
echo 休眠前等待时间：永不
powercfg /setacvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 9d7815a6-7ee4-497e-8888-515a05f02364 0
powercfg /setdcvalueindex 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c 238c9fa8-0aad-41ed-83f4-97be242c8f20 9d7815a6-7ee4-497e-8888-515a05f02364 0
echo 完成
 
echo 开启休眠（快速启动需要）
POWERCFG -H ON
echo 完成
 
ECHO 开启快速启动(Hybrid Boot)
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\System" /v "HiberbootEnabled" /d 1 /t REG_DWORD /f
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
 
echo.
echo                          是不是滚得很快啊？
echo.
echo                               歇会儿！
echo.
ECHO 设置免输密码自动登陆
echo.
echo.
set /p DUN=请输入用户名：
echo.
echo                     什么？你没设密码？
echo.
echo                 按1直接跳过，按2输入你的密码！
echo.
Choice /C 12 /N /M 选择（1、2）：
If ErrorLevel 1 If Not ErrorLevel 2 Goto next
If ErrorLevel 2 If Not ErrorLevel 3 Goto psw
echo.
:psw
set /p PSW1=请输入密码：
set /p PSW2=请再次输入密码确认：
if %PSW1%==%PSW2% goto confirm
echo 两次输入的密码不一致
echo 按任意键返回重新输入
pause>nul
goto psw
 
:confirm
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v "AutoAdminLogon" /d 1 /t REG_SZ /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v "DefaultUserName" /d "%DUN%" /t REG_SZ /f
reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v "DefaultPassword" /d "%PSW1%" /t REG_SZ /f
echo 完成
 
:next
ECHO 更改IE默认下载目录
echo.
echo.
set /p d=请输入IE下载路径(如"D:\迅雷下载"，输入skip跳过)：
if %d%==skip goto skipie
reg add "HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main" /v "Default Download Directory" /d "%d%" /t REG_SZ /f
echo 完成
goto next2
 
:skipie
echo 已经跳过更改IE默认下载目录
ping -n 3 127.0.0.1>nul
 
:next2
ECHO 启用.NET Framework 3.5.1
echo.
echo 请先挂载对应版本的Windows安装镜像
echo.
set /p c=请输入挂载的Windows镜像盘符(输入skip跳过)：
if %c%==skip goto skipnet
dism.exe /online /enable-feature /featurename:NetFX3 /Source:%c%:\sources\sxs
echo 完成
goto next3
 
:skipnet
echo 已经跳过启用.NET Framework 3.5.1功能
ping -n 3 127.0.0.1>nul
 
:next3
ECHO 锁定IE主页设置
echo.
set /p StartPage=请输入要绑定的IE主页网址(输入skip跳过)：
if %StartPage%==skip goto skipStartPage
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Control Panel" /v "HomePage" /d "1" /t REG_DWORD /f
reg add "HKEY_CURRENT_USER\Software\Policies\Microsoft\Internet Explorer\Main" /v "Start Page" /d "%StartPage%" /t REG_SZ /f
echo 完成
goto next4
 
:skipStartPage
echo 已经跳过锁定IE主页设置
ping -n 3 127.0.0.1>nul
 
:next4
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
 
ECHO 关闭操作中心安全维护消息提示
rem 每台机器的键值不一样，可能无效
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{E8433B72-5842-4d43-8645-BC2C35960837}.check.103" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c00000000020000000000106600000001000020000000a7ae8c9aa7ebe4742746b947752993893f926c5854829125b440977d5ee42ce5000000000e800000000200002000000019f8de4a9ee294910a8eb38395fd9a6bb95c9b9539f442f35a849b34959437f5d0000000816e8363d0d3a4ee18b296952d9a75e594bd8b0b70f7958b7ed114e2fc3a5e371cadb4a5a0d5d20a32f73106aa932dee2c77ad82b28e3a62034385ab0b282f60961ee50ac870ca46981ee4a5a57d0040bd3a3f940852f82951d4e08cb8eb0f61be0cc6b28efd6278ab5ad483d19ad2d65cd9fcdc8cdbadf618d2203a45575e407e961158a33f37ec30e504314a9526013c7690a204e8d77c17d6c9fccae82c308dd0070f0c9b237c1a849e8042632cd33f5f5b955c4c6fb5308cae6f76834f26c1a7ab2095037324618aabf8bbe5ffc440000000fce98e4305f7e85d4105e078edd7ca2ff76be6da04a03e476f8af4ca06354805e2bd69c105b43b19732253779f7d92616e5255f86cfc4833f4232770c74cfc10" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{E8433B72-5842-4d43-8645-BC2C35960837}.check.102" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000001e9257367aee8da07d46c24072e826aa1c15f8803c5caca94939cfe119824f02000000000e800000000200002000000035f6e4f999b399b08d58ba843e45dbdff3b2442e92961fb86f8f7c8b16d5b8a4300000002456b2243feec6e4f1cfa2c744ed5cbfc0dd806986c4657031eaf479fbd32aca00f23a1a978df2e3c422adbf2d00b0e3400000008bb2c177465efd545edf842c16b8668f496fe449ab9a640deca042e87175f99fef354a54c6dc4fcb470241f973203775917e4831c22bcfee232673cd29d72736" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{E8433B72-5842-4d43-8645-BC2C35960837}.check.104" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000095e01fab8e686e7732e278bd314cfaaf77fa829dc38c2bdd5d76e98563f5a538000000000e8000000002000020000000fb710f194ef621cfbe95be0d154325dac3ae84ec1c8cabb656e236800d3510af300000000b2c9c9e08bd50d6e15da1e85199ac3b8d6cb6ea024aa429b113982e135116eac3c282c812fd87e4b9edfa7fa22da4a04000000069d82238674bf2ac2089145733156252a4f62629ccfdb1e016b222b40ec6a517940208a9942f37d2a2288f87b8cab3fd47f2a8892ca2113a6eb5dec574fd3cb7" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{C8E6F269-B90A-4053-A3BE-499AFCEC98C4}.check.0" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000085b19b580389f6fe3b433fa4a0dca27cfba7ebe10c75063b0151d03f316fd6d8000000000e80000000020000200000003b1268f462df692609d30181fc1b1bf301feaea81062b2b8d85d0453da9e8b8e30000000cd0a948cf29ecdf35d317d26f81ecb379d987adb1ed174e2f75f70c689f815ea00fe3cf5fcfec9a14b6c32a6a9fb12b2400000003d8c500984a8fd0aea4ed4651d109c55120e89260b8c02f117ee5b2c5255395b10cbb139c40d09f728394f254297a3ce2f73cfe515a405e4afd22264d16df833" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{E8433B72-5842-4d43-8645-BC2C35960837}.check.101" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000008ed73cb7d5922e58de1a7c681e336c27cb43f8b42b60a3148dd37289855494e0000000000e8000000002000020000000690226f5db59f646af3b56ec513ed574f28f7b10d6e1e393e6154351faea91a93000000086b9f35c5099fc9e68510b27bfe7e893999e84b16de9b79b04468708aa23e65ee61b7a4179455f426a0c446d5e5388344000000065e349a51dcd1290427e45e141f652c08c6230c574eea0e688231cd1ea6a1adb1858d21613c5266b0b547fc5b75bb310bba9a72893484d95ee8115f516993fc5" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{E8433B72-5842-4d43-8645-BC2C35960837}.check.100" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000031843580b428b9af9595e96916cbd0f19ea89fde15f69a411682020989314a96000000000e80000000020000200000003de0e0d59079c8bfbf9b5166e4a049d90909799c2f1f163f3cbb6c86d6c3320730000000a9e333647b93b8be971c064c8acbf513de72634e77e134f5c45d46b07899dd8dd8f59245fe0d46f10e05b5af70cc98bc40000000cd231d8f5af986e73f5ba3faab6cd22d3f9d8f329590a9d00cb4d07d31b9309ee838bd6d1a5a11b763ff87c6be3323deb8704b3d22d1a9555857f690d3b3bd67" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{AA4C798D-D91B-4B07-A013-787F5803D6FC}.check.100" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000009fcc53bf42d26d1382ba21052cc6e95f72b4cabbd760958d16ae3ce1ae31b88b000000000e8000000002000020000000bf0937ab1a2925a3c24de07a57af2304b64510b250b9becb7224081e70259147300000002be056aa8b4885c1caf38512603a8737bdfc2ed8c02e558f92f60575322505cb96e4aa0339c9b498fe559847a30b2033400000009ce01ff385c1683e410a9037e790d4ab387a155f1765af79295cbe7a6505917589852416e58f203bb98704e9eedf4b287cb3c709719db1988b3a4369f16e7fdc" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{088E8DFB-2464-4C21-BAD2-F0AA6DB5D4BC}.check.0" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000028cd1e206f2cf507fcbc92e969a0d295fbfa3da5396168e5782b226a030bd355000000000e800000000200002000000046f960055533314629032033a5245ccb8396371e44b7ac1276851bef82b73c3cb000000095becf78ec7b3ee0bde645e90e012895b612050d7baedda7c559b313f1b63977c525bdace6328d30368ade6b45e2590faa8e431b8c9a850d5a39b4efc14a6d7d87e4eaac594ef84823cbde505ed26069b5381052f7906675095d77486849436811d857efee028fc15bd27629bcbbb0d8f5309f599c21d161aabf12d5f46d5489233ab45970978f0dad41555b70b24b1cc41c6361dd628c53c8965555ff68abedf23bb77663b459df2690f8bf57724ab94000000075f55efd57f1474a35cd3dcae355d2818d68c1077e14033f003a45269c38b181236bee8da2cb0be46b9b2895031fe7205322cce56e99f6a3e356c35af486c99a" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{A5268B8E-7DB5-465b-BAB7-BDCDA39A394A}.check.100" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c00000000020000000000106600000001000020000000e695e8667c04dd0f4d08d923501f85fe8563b3827a4ba592c61939475fec2b91000000000e80000000020000200000006949e315402843c96ee8fda5544a1ac42f6a9bd6eb4cca4ef0e5012dc004004a300000003931c03b0fb4074feda7e861127b621a7d8567e74694b1fc31e414c0a64e43b94ca03c662ef5dd4f02b538fd45dff2fa400000008d4db41e4620392cf7547242b390e93f6cdb0c262e753e95907bfc0d6f5231c51e3cf90d0414eac90c266c48348d6ead8a5d58429a3d26c3c4cee1b456ad4d1d" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{DE7B24EA-73C8-4A09-985D-5BDADCFA9017}.check.800" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c00000000020000000000106600000001000020000000423224b166383a4d4e44448ba3acf9e8d76f48fb6bd75e7c231b26f60bef45a1000000000e8000000002000020000000e5519266fa33c0f487c7d6a941eba4567135aa00021ab0bd11f47747dadca4ec30000000f1fb6d84e093d6b301753ac41d267b1d7358cdf60cddfd503c474baff922763c82b469ac20e35e3e235bb2a27851ac8f4000000054f9af44b6227ea3d532441f6016cae024dc3d30ed3cbf5fe907b0251d66c01bc934d59b555eab44d3e74e9e19203fe8f542f9f4179d12244f8017f2381b8521" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{134EA407-755D-4A93-B8A6-F290CD155023}.check.8001" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000099cdf3e35d5aa882686ec6f1ba04bc0caa08909ee0eb5d08c7e3c1d83f4433cb000000000e80000000020000200000002443ee5a1aa568ef9e81864f5a36b8bdd07d7f6527cf1efabbf4a12da9c29eab300000000c84bdba546d23384c2cd0d41b4497c4c497e7d224fe64c22e732d7cd213fabd5106a12869c0a4ea3117101c6cb1b926400000006515acca5e4fb32322986c5712acca13b2d09a9128cf96e6c28abb387211f02364e7380eecdd540576551e467a3594807f1b05862be34655f5ca5eaf2f61463a" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{3FF37A1C-A68D-4D6E-8C9B-F79E8B16C482}.check.100" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000006e652b9b5ec7b232b39b290ab11f455271fc65328547ed66c234afd43b7d94c4000000000e8000000002000020000000868691bf70dd349be3d3013fd10739b9abf7dc4ce1e660adff0a6303f003230f300000007fd6a05c4d3f4cd311f0f1278ba8f8ee0d7c1f40d3ac92b60292f73fe05a2ce9d3cdd7c4a2704d247f5236ac775527ed400000008b6fa60beed92722cc51f85b215d35f27b8d727be389e9536be3af372d28166c8688e42116d5de5b5b0b1c0fd7bc17c5d6e775f27c894b535886172eb36d2c97" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{B447B4DB-7780-11E0-ADA3-18A90531A85A}.check.100" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c0000000002000000000010660000000100002000000025562ebd3620e15eaa8d457a1b50728391c026a3827cc98c5419d54b66f88a62000000000e8000000002000020000000431cb93d711ce24c4030972f3ebf4ed20f4bb491514349647768cf491557799b30000000531d8d6644f48d3bed8e9f259fe21f2143de08c9177c87f162171f8cb55007e1020011c183501bb78851de4462ff7b44400000006f8228ca663f124cd6e066c96d287188982829b53f046f2b7ce5d39d2092a6b7f341546f2022158453d02730a03f6a19e25520884893451b7d52460f04974370" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{96F4A050-7E31-453C-88BE-9634F4E02139}.check.8010" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000005deacb32849d483088eeddb48bb3f83ef11e8790bd2f58155745ce7c633c84df000000000e8000000002000020000000288aad23ccf0b6078c8e4048b2f95952df4e93f8b10326f8653b2df2df8493463000000048ae2fc754b39bb862c55a1f866dc36e9a26fb30a37f89f7c5fdc370ddc3688d99e5d652367e6c26df3b6e74ae930a75400000000cbaf6edc265ed46816083afc7c7420d5a5348f74d0677fd329ec0691533bdcfe182960beb2f60f286a145888552cbae7ed2b9483994c42e057463d884e0351d" /t REG_BINARY /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Action Center\Checks\{34A3697E-0F10-4E48-AF3C-F869B5BABEBB}.check.9001" /v CheckSetting /d "01000000d08c9ddf0115d1118c7a00c04fc297eb010000006049bbbf6216294aa2953641ffc9152c000000000200000000001066000000010000200000001573ab5723ff839facc6ee929c9336c9ab236cf4ad09dc07678eeac8505be012000000000e80000000020000200000008b2ae9609c87ac04361a911adb451101d23de4cbd2614c78cf8714d7dda546cb3000000053c36193ede228b4775ceba48be0d2b2da6bd258d3d0652de6613d9877bb47a74d981a0412a7815a300db6409e0cd2b640000000548d75a77900aead0943e8f1742fe0f273c51a677269e66df1439e880cedbd6e7ee8a310dafd23729c9d20b71feed70968101c37aa421f8f4d073dc03bf0b565" /t REG_BINARY /f
echo 完成
 
echo 打开IE请勿追踪功能(Do Not Track)
reg add "HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main" /v "DoNotTrack" /d "1" /t REG_DWORD /f
taskkill /f /im iexplore.exe
ECHO 完成
 
 
gpupdate /force
taskkill /f /im explorer.exe
start %systemroot%\explorer
 
rem 切换回高性能
powercfg.exe -setactive 8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c
rem reg add "HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Power\PowerSettings" /v "ActivePowerScheme" /d "8c5e7fda-e8bf-4a96-9a85-a6e23a8c635c" /t REG_SZ /f
 
 
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
echo                               按任意键立即重启系统
echo.
echo.
echo.
echo.
echo.
echo.
echo.
echo.
pause>nul
shutdown -r -t 0
 
:admin
CLS
COLOR 0a
MODE con: COLS=30 LINES=8
ECHO 操作失败。
echo 请右键“以管理员身份运行”
ECHO 按任意键退出...
PAUSE >nul
exit
