
@ECHO OFF & CHCP 936 1>NUL 2>NUL & TITLE Windows 10 一键优化
@ECHO OFF & (REG QUERY "HKEY_USERS\S-1-5-19" >NUL 2>NUL) || (ECHO. && ECHO 请以管理员身份运行! 按任意键退出... && PAUSE >NUL && EXIT)

COLOR 1F
CALL:initCheckFileIntegrity

ECHO.
ECHO --------------------------------------------------------------------------------
ECHO     脚本仅支持以下 Windows 10 系统, 其他系统版本请勿运行此脚本! 
ECHO.
ECHO     Windows 10 Enterprise LTSC 2019 (2019-03-15)
ECHO     Windows 10 Version 1909 (Updated April 2020) (2020-04-21)
ECHO.
ECHO     带有"通用优化"文字的优化方案会进行以下优化:
ECHO --------------------------------------------------------------------------------
ECHO     禁用 Windows 开始菜单, 任务栏等的动画效果
ECHO     禁用 Windows 各种反馈, 建议, 广告, 应用推广
ECHO     禁用 备份与还原, 系统保护
ECHO     禁用 xbox, OneDrive, Cortana
ECHO     禁用 搜索时进行 Web 云搜索
ECHO     禁用 已安装软件的计划任务 (一般都是软件的更新检查)
ECHO     关闭 应用商店自动下载更新
ECHO     更改 当前电源选项计划方案 (从不自动睡眠, 休眠, 关硬盘; 启用系统休眠功能 等)
ECHO     更改 锁屏界面 (将 Windows 聚焦 更改为 图片)
ECHO     *修复 无法使用打印机, 无法更换锁屏背景 的问题
ECHO     *恢复 一些无关 CPU 高占用的服务
ECHO     还有更多的优化需要你来体验!
ECHO --------------------------------------------------------------------------------
ECHO     脚本执行完成后, 需要立即重启才能生效! 重启前请勿对系统做其他操作!
ECHO     如果您有未保存的重要文件, 请确认保存后再来执行该脚本!
ECHO     如发现有重大问题, 请及时反馈!
ECHO --------------------------------------------------------------------------------
ECHO     按任意键开始, 或按 Ctrl + C 退出脚本
PAUSE >NUL


:menu
TITLE Windows 10 一键优化 - 选择优化方案
CLS
COLOR 0F
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     请选择优化方案:
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     [1] 危险通用优化 (包括执行 [3] 号方案)
ECHO.
ECHO     [2] 安全通用优化 (包括执行 [4] 号方案)
ECHO.
ECHO     [3] 禁用 Windows 更新 (彻底禁用 Windows 更新, 并禁用 Microsoft Defender)
ECHO.
ECHO     [4] 启用 Windows 更新 (禁用自动更新, 但启用手动更新, 启用 Microsoft Defender)
ECHO.
ECHO     [0] 退出脚本
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     注意: 执行完成后需要立即重启才能使优化生效!
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.

CHOICE /C:12340 /N /M:"请输入数字选择:"
TITLE Windows 10 一键优化 - 执行优化方案
CLS
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO.
ECHO     正在执行优化方案, 请等待完成!
ECHO.
ECHO --------------------------------------------------------------------------------
IF ERRORLEVEL 5 EXIT
IF ERRORLEVEL 4 CALL:enableWindowsUpdate
IF ERRORLEVEL 3 CALL:disableWindowsUpdate
IF ERRORLEVEL 2 CALL:securityCommonOptimization
IF ERRORLEVEL 1 CALL:dangerCommonOptimization



ECHO. 
ECHO. 
ECHO.
ECHO     重启即可生效! 重启前请勿对系统进行操作!
ECHO. 
ECHO. 
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO.
ECHO     按任意键退出脚本...
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO. 
PAUSE >NUL && EXIT



:initCheckFileIntegrity
@REM 初始化检查文件完整性
SET "currentPath=%~DP0regs"

SET "commonGroupPolicy=%currentPath%\01-common-group-policy.reg"
SET "dangerGroupPolicy=%currentPath%\01-danger-group-policy.reg"
SET "securityGroupPolicy=%currentPath%\01-security-group-policy.reg"

SET "commonService=%currentPath%\11-common-service.reg"
SET "dangerService=%currentPath%\11-danger-service.reg"
SET "securityService=%currentPath%\11-security-service.reg"

SET "commonControlPanel=%currentPath%\21-common-control-panel.reg"
SET "dangerControlPanel=%currentPath%\21-danger-control-panel.reg"
SET "securityControlPanel=%currentPath%\21-security-control-panel.reg"

SET "commonSettings=%currentPath%\31-common-settings.reg"

SET "commonMiscellaneous=%currentPath%\41-common-miscellaneous.reg"

SET "disableWindowsUpdate=%currentPath%\windows-update\disable.reg"
SET "enableWindowsUpdate=%currentPath%\windows-update\enable.reg"

IF NOT EXIST "%currentPath%" (
    ECHO. 
    ECHO [00] 未知错误! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonGroupPolicy%" (
    ECHO. 
    ECHO [01-c] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerGroupPolicy%" (
    ECHO. 
    ECHO [01-d] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityGroupPolicy%" (
    ECHO. 
    ECHO [01-s] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonService%" (
    ECHO. 
    ECHO [11-c] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerService%" (
    ECHO. 
    ECHO [11-d] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityService%" (
    ECHO. 
    ECHO [11-s] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonControlPanel%" (
    ECHO. 
    ECHO [21-c] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerControlPanel%" (
    ECHO. 
    ECHO [21-d] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityControlPanel%" (
    ECHO. 
    ECHO [21-s] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonSettings%" (
    ECHO. 
    ECHO [31-c] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonMiscellaneous%" (
    ECHO. 
    ECHO [41-c] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%disableWindowsUpdate%" (
    ECHO. 
    ECHO [wu-d] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%enableWindowsUpdate%" (
    ECHO. 
    ECHO [wu-e] 部分文件缺失, 请重新下载! 按任意键退出...
    PAUSE >NUL && EXIT
)
GOTO:EOF


:setLockScreen
@REM 锁屏界面
FOR /f %%i IN ('REG QUERY "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Authentication\LogonUI\Creative" /f "S-1-5-21-*" /k /c') DO (
    @REM 图片-背景
    REG ADD "%%i" /v "RotatingLockScreenEnabled" /t REG_DWORD /d "0" /f >NUL 2>NUL
    @REM 关闭-在锁屏界面上获取花絮, 提示, 技巧等
    REG ADD "%%i" /v "RotatingLockScreenOverlayEnabled" /t REG_DWORD /d "0" /f >NUL 2>NUL
)
GOTO:EOF


:setSchtasks
@REM 计划任务程序
@REM 禁用-磁盘碎片整理计划
SCHTASKS /End /TN "\Microsoft\Windows\Defrag\ScheduledDefrag" >NUL 2>NUL
SCHTASKS /Change /TN "\Microsoft\Windows\Defrag\ScheduledDefrag" /DISABLE >NUL 2>NUL
@REM 禁用-非系统自带的计划任务
SET "tempListFile1=%TMP%\tempListFile1.txt"
SET "tempListFile2=%TMP%\tempListFile2.txt"
DEL /F /Q "%tempListFile2%" >NUL 2>NUL
DIR "C:\Windows\System32\Tasks" /A-D /B /S>%tempListFile1%
FOR /f "delims=" %%i IN (%tempListFile1%) DO (
    CALL:substringTasksPath "%%i"
)
FINDSTR /R /I /V "^\\Microsoft\\." "%tempListFile2%">"%tempListFile1%"
FOR /f "delims=" %%i IN (%tempListFile1%) DO (
    SCHTASKS /End /TN "%%i" >NUL 2>NUL
    SCHTASKS /Change /TN "%%i" /DISABLE >NUL 2>NUL
)
DEL /F /Q "%tempListFile2%" >NUL 2>NUL
DEL /F /Q "%tempListFile1%" >NUL 2>NUL
GOTO:EOF


:setPowercfg
@REM 控制面板: 电源选项
@REM 开启休眠 (关闭了休眠, 发现开机启动太慢)
POWERCFG /H ON >NUL 2>NUL
@REM 从不-关闭显示器
POWERCFG /CHANGE monitor-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE monitor-timeout-dc 0 >NUL 2>NUL
@REM 从不-使计算机进入睡眠状态
POWERCFG /CHANGE standby-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE standby-timeout-dc 0 >NUL 2>NUL
@REM 从不-在此时间后关闭硬盘
POWERCFG /CHANGE disk-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE disk-timeout-dc 0 >NUL 2>NUL
@REM 从不-计算机进入休眠状态的时间
POWERCFG /CHANGE hibernate-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE hibernate-timeout-dc 0 >NUL 2>NUL
GOTO:EOF


:substringTasksPath
@REM 截取任务计划路径
SET "str=%~1"
SET "str=%str::\Windows\System32\Tasks\=\//\%"
FOR /f "tokens=2 delims=//" %%i IN ("%str%") DO (
    ECHO %%i>>"%tempListFile2%"
)
GOTO:EOF


:enableWindowsUpdate
@REM 启用 Windows 更新
CALL:windowsUpdateOptimization "2"
GOTO:EOF


:disableWindowsUpdate
@REM 禁用 Windows 更新
CALL:windowsUpdateOptimization "1"
GOTO:EOF


:windowsUpdateOptimization
@REM Windows 更新优化
IF "1"=="%~1" (REGEDIT /s "%disableWindowsUpdate%") ELSE (REGEDIT /s "%enableWindowsUpdate%")
GOTO:EOF


:dangerCommonOptimization
@REM 危险通用优化
CALL:commonOptimization "1"
GOTO:EOF


:securityCommonOptimization
@REM 安全通用优化
CALL:commonOptimization "2"
GOTO:EOF


:commonOptimization
@REM 通用优化
REGEDIT /s "%commonGroupPolicy%"
IF "1"=="%~1" (REGEDIT /s "%dangerGroupPolicy%") ELSE (REGEDIT /s "%securityGroupPolicy%")

REGEDIT /s "%commonService%"
IF "1"=="%~1" (REGEDIT /s "%dangerService%") ELSE (REGEDIT /s "%securityService%")

REGEDIT /s "%commonControlPanel%"
IF "1"=="%~1" (REGEDIT /s "%dangerControlPanel%") ELSE (REGEDIT /s "%securityControlPanel%")

REGEDIT /s "%commonSettings%"
REGEDIT /s "%commonMiscellaneous%"

CALL:setLockScreen
CALL:setSchtasks
CALL:setPowercfg
GOTO:EOF

