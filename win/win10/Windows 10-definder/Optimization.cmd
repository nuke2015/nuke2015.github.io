
@ECHO OFF & CHCP 936 1>NUL 2>NUL & TITLE Windows 10 һ���Ż�
@ECHO OFF & (REG QUERY "HKEY_USERS\S-1-5-19" >NUL 2>NUL) || (ECHO. && ECHO ���Թ���Ա�������! ��������˳�... && PAUSE >NUL && EXIT)

COLOR 1F
CALL:initCheckFileIntegrity

ECHO.
ECHO --------------------------------------------------------------------------------
ECHO     �ű���֧������ Windows 10 ϵͳ, ����ϵͳ�汾�������д˽ű�! 
ECHO.
ECHO     Windows 10 Enterprise LTSC 2019 (2019-03-15)
ECHO     Windows 10 Version 1909 (Updated April 2020) (2020-04-21)
ECHO.
ECHO     ����"ͨ���Ż�"���ֵ��Ż���������������Ż�:
ECHO --------------------------------------------------------------------------------
ECHO     ���� Windows ��ʼ�˵�, �������ȵĶ���Ч��
ECHO     ���� Windows ���ַ���, ����, ���, Ӧ���ƹ�
ECHO     ���� �����뻹ԭ, ϵͳ����
ECHO     ���� xbox, OneDrive, Cortana
ECHO     ���� ����ʱ���� Web ������
ECHO     ���� �Ѱ�װ����ļƻ����� (һ�㶼������ĸ��¼��)
ECHO     �ر� Ӧ���̵��Զ����ظ���
ECHO     ���� ��ǰ��Դѡ��ƻ����� (�Ӳ��Զ�˯��, ����, ��Ӳ��; ����ϵͳ���߹��� ��)
ECHO     ���� �������� (�� Windows �۽� ����Ϊ ͼƬ)
ECHO     *�޸� �޷�ʹ�ô�ӡ��, �޷������������� ������
ECHO     *�ָ� һЩ�޹� CPU ��ռ�õķ���
ECHO     ���и�����Ż���Ҫ��������!
ECHO --------------------------------------------------------------------------------
ECHO     �ű�ִ����ɺ�, ��Ҫ��������������Ч! ����ǰ�����ϵͳ����������!
ECHO     �������δ�������Ҫ�ļ�, ��ȷ�ϱ��������ִ�иýű�!
ECHO     �緢�����ش�����, �뼰ʱ����!
ECHO --------------------------------------------------------------------------------
ECHO     ���������ʼ, �� Ctrl + C �˳��ű�
PAUSE >NUL


:menu
TITLE Windows 10 һ���Ż� - ѡ���Ż�����
CLS
COLOR 0F
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     ��ѡ���Ż�����:
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     [1] Σ��ͨ���Ż� (����ִ�� [3] �ŷ���)
ECHO.
ECHO     [2] ��ȫͨ���Ż� (����ִ�� [4] �ŷ���)
ECHO.
ECHO     [3] ���� Windows ���� (���׽��� Windows ����, ������ Microsoft Defender)
ECHO.
ECHO     [4] ���� Windows ���� (�����Զ�����, �������ֶ�����, ���� Microsoft Defender)
ECHO.
ECHO     [0] �˳��ű�
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.
ECHO     ע��: ִ����ɺ���Ҫ������������ʹ�Ż���Ч!
ECHO.
ECHO ------------------------------------------------------------------------------------------
ECHO.

CHOICE /C:12340 /N /M:"����������ѡ��:"
TITLE Windows 10 һ���Ż� - ִ���Ż�����
CLS
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO.
ECHO     ����ִ���Ż�����, ��ȴ����!
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
ECHO     ����������Ч! ����ǰ�����ϵͳ���в���!
ECHO. 
ECHO. 
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO.
ECHO     ��������˳��ű�...
ECHO.
ECHO --------------------------------------------------------------------------------
ECHO. 
PAUSE >NUL && EXIT



:initCheckFileIntegrity
@REM ��ʼ������ļ�������
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
    ECHO [00] δ֪����! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonGroupPolicy%" (
    ECHO. 
    ECHO [01-c] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerGroupPolicy%" (
    ECHO. 
    ECHO [01-d] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityGroupPolicy%" (
    ECHO. 
    ECHO [01-s] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonService%" (
    ECHO. 
    ECHO [11-c] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerService%" (
    ECHO. 
    ECHO [11-d] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityService%" (
    ECHO. 
    ECHO [11-s] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonControlPanel%" (
    ECHO. 
    ECHO [21-c] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%dangerControlPanel%" (
    ECHO. 
    ECHO [21-d] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%securityControlPanel%" (
    ECHO. 
    ECHO [21-s] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonSettings%" (
    ECHO. 
    ECHO [31-c] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%commonMiscellaneous%" (
    ECHO. 
    ECHO [41-c] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%disableWindowsUpdate%" (
    ECHO. 
    ECHO [wu-d] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)

IF NOT EXIST "%enableWindowsUpdate%" (
    ECHO. 
    ECHO [wu-e] �����ļ�ȱʧ, ����������! ��������˳�...
    PAUSE >NUL && EXIT
)
GOTO:EOF


:setLockScreen
@REM ��������
FOR /f %%i IN ('REG QUERY "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Authentication\LogonUI\Creative" /f "S-1-5-21-*" /k /c') DO (
    @REM ͼƬ-����
    REG ADD "%%i" /v "RotatingLockScreenEnabled" /t REG_DWORD /d "0" /f >NUL 2>NUL
    @REM �ر�-�����������ϻ�ȡ����, ��ʾ, ���ɵ�
    REG ADD "%%i" /v "RotatingLockScreenOverlayEnabled" /t REG_DWORD /d "0" /f >NUL 2>NUL
)
GOTO:EOF


:setSchtasks
@REM �ƻ��������
@REM ����-������Ƭ����ƻ�
SCHTASKS /End /TN "\Microsoft\Windows\Defrag\ScheduledDefrag" >NUL 2>NUL
SCHTASKS /Change /TN "\Microsoft\Windows\Defrag\ScheduledDefrag" /DISABLE >NUL 2>NUL
@REM ����-��ϵͳ�Դ��ļƻ�����
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
@REM �������: ��Դѡ��
@REM �������� (�ر�������, ���ֿ�������̫��)
POWERCFG /H ON >NUL 2>NUL
@REM �Ӳ�-�ر���ʾ��
POWERCFG /CHANGE monitor-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE monitor-timeout-dc 0 >NUL 2>NUL
@REM �Ӳ�-ʹ���������˯��״̬
POWERCFG /CHANGE standby-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE standby-timeout-dc 0 >NUL 2>NUL
@REM �Ӳ�-�ڴ�ʱ���ر�Ӳ��
POWERCFG /CHANGE disk-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE disk-timeout-dc 0 >NUL 2>NUL
@REM �Ӳ�-�������������״̬��ʱ��
POWERCFG /CHANGE hibernate-timeout-ac 0 >NUL 2>NUL
POWERCFG /CHANGE hibernate-timeout-dc 0 >NUL 2>NUL
GOTO:EOF


:substringTasksPath
@REM ��ȡ����ƻ�·��
SET "str=%~1"
SET "str=%str::\Windows\System32\Tasks\=\//\%"
FOR /f "tokens=2 delims=//" %%i IN ("%str%") DO (
    ECHO %%i>>"%tempListFile2%"
)
GOTO:EOF


:enableWindowsUpdate
@REM ���� Windows ����
CALL:windowsUpdateOptimization "2"
GOTO:EOF


:disableWindowsUpdate
@REM ���� Windows ����
CALL:windowsUpdateOptimization "1"
GOTO:EOF


:windowsUpdateOptimization
@REM Windows �����Ż�
IF "1"=="%~1" (REGEDIT /s "%disableWindowsUpdate%") ELSE (REGEDIT /s "%enableWindowsUpdate%")
GOTO:EOF


:dangerCommonOptimization
@REM Σ��ͨ���Ż�
CALL:commonOptimization "1"
GOTO:EOF


:securityCommonOptimization
@REM ��ȫͨ���Ż�
CALL:commonOptimization "2"
GOTO:EOF


:commonOptimization
@REM ͨ���Ż�
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

