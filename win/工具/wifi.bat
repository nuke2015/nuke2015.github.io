wifi.cmd

@ECHO OFF
Title �����ȵ����ù���
color 0a
Pushd %~dp0
If "%PROCESSOR_ARCHITECTURE%"=="AMD64" (Set b=%SystemRoot%\SysWOW64) Else (Set b=%SystemRoot%\system32)
Rd "%b%\test_permission_test" >nul 2>nul
Md "%b%\test_permission_test" 2>nul||(Echo ��ʹ���Ҽ�����Ա�������&&Pause >nul&&Exit)
Rd "%b%\test_permission_test" >nul 2>nul
setlocal ENABLEDELAYEDEXPANSION

GOTO MENU
:MENU
cls
ECHO.
ECHO.          =-=-=-=-=��ѡ��Ҫ�����������ȵ㣨wifi��������Ŀ=-=-=-=-=
ECHO.
ECHO.                       1  �鿴���������Ƿ�֧��wifi�ȵ㹦��
Echo.
ECHO.                       2  ��һ�����ò�����wifi�ȵ�
ECHO.
ECHO.                       3  �������е�wifi�ȵ�
ECHO.
ECHO.                       4  �鿴wifi��Ϣ
ECHO.          
ECHO.                       5  �ر�wifi�ȵ�
ECHO.
ECHO.                       6  ��     ��
ECHO.
ECHO.
ECHO.
ECHO.

Set /p c=���������ֲ���Enterȷ����
IF NOT "%c%"=="" SET c=%c:~0,1%
If "%c%"=="1" Goto wifi_verify
If "%c%"=="2" Goto wifi_config
If "%c%"=="3" Goto wifi_start
If "%c%"=="4" Goto wifi_show
If "%c%"=="5" Goto wifi_stop
If "%c%"=="6" Goto exit
GOTO MENU

:wifi_verify
cls
ECHO =-=-=-=-=�������������Ƿ�֧��wifi�ȵ㹦�ܣ�=-=-=-=-=
ECHO.
ECHO.
IF EXIST "%b%\netsh.exe" netsh interface set interface name="������������" admin=ENABLED
Set supportWifi="false"
netsh wlan show drivers | find "֧�ֵĳ�������  : ��" >nul&&If "1"=="1" (Set supportWifi="true")
if %supportWifi%=="true" (set/p=<nul&echo.> ��ϲ����������������֧��wifi�ȵ㹦�ܣ��Ͽ�ȥ�����ɣ���&findstr /a:0c .* ��ϲ����*&del ��ϲ����*) else (set/p=<nul&echo.> ���ź�����������������֧��wifi�ȵ㹦�ܣ��������������԰ѣ���&findstr /a:0c .* ���ź���*&del ���ź���*) 
echo.
ECHO.
ECHO.
pause
GOTO MENU


:wifi_config
cls
ECHO. =-=-=-=-=����һ�������ȵ�=-=-=-=-=
ECHO.
echo ��һ����������SSID Enter����
echo.
:begin
set /p SSID=��������SSID��
if "%SSID:~1,1%"==""  echo ��������2λ&goto begin
echo.
echo.
echo.
echo.
:key
echo �ڶ���������8λ���������� Enter����
echo.
set /p pw=����������(8-16λ)��
if "%pw:~7,1%"==""  echo ��������8λ&goto key
if "%pw:~16,1%" neq "" echo ����16λ��&goto key
echo ^[WLAN_SSID^]>config.ini
echo WLAN_SSID^=%SSID%>>config.ini
echo.>>config.ini
echo ^[WLAN_PASSWORD^]>>config.ini
echo WLAN_PASSWORD^=%PW%>>config.ini
echo.>>config.ini
echo.
netsh interface set interface name="������������" admin=ENABLED
netsh wlan set hostednetwork mode=allow
netsh wlan set hostednetwork ssid=%SSID% key=%PW%
netsh wlan start hostednetwork
echo ���ڲ��ҵ�ǰ����ʹ�õ���������,���Ե�....
Getmac /v /nh /fo csv | find /i "Device" > network_all.txt
ping 127.0.0.1>nul
for /f "tokens=1-3* delims=," %%a in (network_all.txt) do if not "%%d"==""ý�屻�Ͽ�"" (
    set myname=%%a
    rem ����:%%b
    set mymac=%%c
    rem Э��:%%d
)
set myname=%myname:~1,-1%
set mymac=%mymac:~1,-1%
echo ��ǰmacΪ%mymac%���������ƽ���"%myname%"
echo.
netsh interface set interface name="%myname%" newname="wlan_ap"
net start MpsSvc
cscript /nologo "%~dp0\ics.vbs" "wlan_ap" "��������" "on" >nul
net stop MpsSvc
set/p=<nul&echo.>��ϲ����wifi������Ѿ��������&findstr /a:0e .*  ��ϲ����wifi������Ѿ��������*&del ��ϲ����wifi������Ѿ��������*
ECHO.
set/p=<nul&echo.>��SSID��"%ssid%"���룺"%pw%"��&findstr /a:0c .*  ��SSID��*&del ��SSID��*
ECHO.
ECHO.
pause
GOTO MENU

:wifi_start
cls
if exist config.ini (echo �����ļ���ȷ��...) else (goto wifi_config)
FOR /F "tokens=1,2 delims==" %%i in (config.ini) DO (
SET %%i=%%j
)
netsh interface set interface name="������������" admin=ENABLED
netsh wlan set hostednetwork mode=allow
netsh wlan set hostednetwork ssid=%WLAN_SSID% key=%WLAN_PASSWORD%
netsh wlan start hostednetwork
net start MpsSvc
cscript /nologo "%~dp0\ics.vbs" "wlan_ap" "��������" "on" >nul
net stop MpsSvc
set/p=<nul&echo.>��ϲ����wifi������Ѿ��������&findstr /a:0e .*  ��ϲ����wifi������Ѿ��������*&del ��ϲ����wifi������Ѿ��������*
ECHO.
set/p=<nul&echo.>��SSID��"%WLAN_SSID%"���룺"%WLAN_PASSWORD%"��&findstr /a:0c .*  ��SSID��*&del ��SSID��*
ECHO.
pause
GOTO MENU


:wifi_show
cls
ECHO. =-=-=-=-=wifi�ȵ�״̬=-=-=-=-=
ECHO.
ECHO.
netsh wlan show hostednetwork
ECHO.
ECHO.
ECHO.
ECHO.
pause
GOTO MENU

:wifi_stop
ECHO. =-=-=-=-=�ر������ȵ����=-=-=-=-=
ECHO.
ECHO.
netsh wlan set hostednetwork mode=disallow
netsh wlan stop hostednetwork
cscript /nologo "%~dp0\ics.vbs"  "������������ 4" "��������" off >nul
netsh interface set interface name="������������" admin=DISABLED
ECHO.
set/p=<nul&echo.>wifi�ȵ㹦���Ѿ��ɹ��رգ�����&findstr /a:0c .*  wifi�ȵ�*&del wifi�ȵ�*
ECHO.
ECHO.
pause
GOTO MENU


:Exit
cls

------------------------------------

ics.vbs


'cscript /nologo ics.vbs "������������" "��������" "off"
'�����ϴ��뱣��Ϊ*.bat�ļ����У����������ֱ�Ϊ�����������ӵ��������֡��ṩ������������ơ�����(on)�ر�(off)
' VBScript source code
OPTION EXPLICIT
DIM ICSSC_DEFAULT, CONNECTION_PUBLIC, CONNECTION_PRIVATE, CONNECTION_ALL
DIM NetSharingManager
DIM PublicConnection, PrivateConnection
DIM EveryConnectionCollection

DIM objArgs
DIM priv_con, publ_con
dim switch

ICSSC_DEFAULT         = 0
CONNECTION_PUBLIC     = 0
CONNECTION_PRIVATE    = 1
CONNECTION_ALL        = 2

Main()

sub Main( )
    Set objArgs = WScript.Arguments

    if objArgs.Count = 3 then
        priv_con = objArgs(0)'����������
                publ_con = objArgs(1)'����������
                switch = objArgs(2)'״̬�л����� on Ϊ ��ics  off �෴

        if Initialize() = TRUE then
            GetConnectionObjects()
            FirewallTestByName priv_con,publ_con
        end if
    else
        DIM szMsg
        if Initialize() = TRUE then
            GetConnectionObjects()
            FirewallTestByName "list","list"
        end if

        szMsg = "To share your internet connection, please provide the name of the private and public connections as the argument." & vbCRLF & vbCRLF & _
                "Usage:" & vbCRLF & _
                "       " & WScript.scriptname & " " & chr(34) & "Private Connection Name" & chr(34) & " " & chr(34) & "Public Connection Name" & chr(34)
        WScript.Echo( szMsg & vbCRLF & vbCRLF)
    end if
end sub

sub FirewallTestByName(con1,con2)
        on error resume next
    DIM Item
    DIM EveryConnection
    DIM objNCProps
    DIM szMsg
    DIM bFound1,bFound2

    WScript.echo(vbCRLF & vbCRLF)
    bFound1 = false
    bFound2 = false
    for each Item in EveryConnectionCollection
        set EveryConnection = NetSharingManager.INetSharingConfigurationForINetConnection(Item)
        set objNCProps = NetSharingManager.NetConnectionProps(Item)
        szMsg = "Name: "       & objNCProps.Name & vbCRLF & _
                "Guid: "       & objNCProps.Guid & vbCRLF & _
                "DeviceName: " & objNCProps.DeviceName & vbCRLF & _
                "Status: "     & objNCProps.Status & vbCRLF & _
                "MediaType: "  & objNCProps.MediaType
        if EveryConnection.SharingEnabled then
            szMsg = szMsg & vbCRLF & _
                    "SharingEnabled" & vbCRLF & _
                    "SharingType: " & ConvertConnectionTypeToString(EveryConnection.SharingConnectionType)
        end if

        if objNCProps.Name = con1 then
            bFound1 = true
            if EveryConnection.SharingEnabled = False and switch="on" then
                szMsg = szMsg & vbCRLF & "Not Shared... Enabling private connection share..."
                WScript.Echo(szMsg)
                EveryConnection.EnableSharing CONNECTION_PRIVATE
                szMsg = " Shared!"
                                                elseif(switch = "off") then 
                                                                szMsg = szMsg & vbCRLF & "Shared... DisEnabling private connection share..."
                WScript.Echo(szMsg)
                                                                EveryConnection.EnableSharing CONNECTION_ALL
                                
            end if
                        end if

        if objNCProps.Name = con2 then
            bFound2 = true
            if EveryConnection.SharingEnabled = False and switch="on" then
                szMsg = szMsg & vbCRLF & "Not Shared... Enabling public connection share..."
                WScript.Echo(szMsg)
                EveryConnection.EnableSharing CONNECTION_PUBLIC
                szMsg = " Shared!"
                                                elseif(switch = "off") then 
                                                                szMsg = szMsg & vbCRLF & "Shared... DisEnabling public connection share..."
                WScript.Echo(szMsg)
                                                                EveryConnection.EnableSharing CONNECTION_ALL
                   end if
        end if
        WScript.Echo(szMsg & vbCRLF & vbCRLF)
    next

    if( con1 <> "list" ) then
        if( bFound1 = false ) then
            WScript.Echo( "Connection " & chr(34) & con1 & chr(34) & " was not found" )
        end if
        if( bFound2 = false ) then
            WScript.Echo( "Connection " & chr(34) & con2 & chr(34) & " was not found" )
        end if
    end if
end sub

function Initialize()
    DIM bReturn
    bReturn = FALSE

    set NetSharingManager = Wscript.CreateObject("HNetCfg.HNetShare.1")
    if (IsObject(NetSharingManager)) = FALSE then
        Wscript.Echo("Unable to get the HNetCfg.HnetShare.1 object")
    else
        if (IsNull(NetSharingManager.SharingInstalled) = TRUE) then
            Wscript.Echo("Sharing isn't available on this platform.")
        else
            bReturn = TRUE
        end if
    end if
    Initialize = bReturn
end function

function GetConnectionObjects()
    DIM bReturn
    DIM Item

    bReturn = TRUE

    if GetConnection(CONNECTION_PUBLIC) = FALSE then
        bReturn = FALSE
    end if

    if GetConnection(CONNECTION_PRIVATE) = FALSE then
        bReturn = FALSE
    end if

    if GetConnection(CONNECTION_ALL) = FALSE then
        bReturn = FALSE
    end if

    GetConnectionObjects = bReturn

end function


function GetConnection(CONNECTION_TYPE)
    DIM bReturn
    DIM Connection
    DIM Item
    bReturn = TRUE

    if (CONNECTION_PUBLIC = CONNECTION_TYPE) then
        set Connection = NetSharingManager.EnumPublicConnections(ICSSC_DEFAULT)
        if (Connection.Count > 0) and (Connection.Count < 2) then
            for each Item in Connection
                set PublicConnection = NetSharingManager.INetSharingConfigurationForINetConnection(Item)
            next
        else
            bReturn = FALSE
        end if
    elseif (CONNECTION_PRIVATE = CONNECTION_TYPE) then
        set Connection = NetSharingManager.EnumPrivateConnections(ICSSC_DEFAULT)
        if (Connection.Count > 0) and (Connection.Count < 2) then
            for each Item in Connection
                set PrivateConnection = NetSharingManager.INetSharingConfigurationForINetConnection(Item)
            next
        else
            bReturn = FALSE
        end if
    elseif (CONNECTION_ALL = CONNECTION_TYPE) then
        set Connection = NetSharingManager.EnumEveryConnection
        if (Connection.Count > 0) then
            set EveryConnectionCollection = Connection
        else
            bReturn = FALSE
        end if
    else
        bReturn = FALSE
    end if

    if (TRUE = bReturn)  then
        if (Connection.Count = 0) then
            Wscript.Echo("No " + CStr(ConvertConnectionTypeToString(CONNECTION_TYPE)) + " connections exist (Connection.Count gave us 0)")
            bReturn = FALSE
        'valid to have more than 1 connection returned from EnumEveryConnection
        elseif (Connection.Count > 1) and (CONNECTION_ALL <> CONNECTION_TYPE) then
            Wscript.Echo("ERROR: There was more than one " + ConvertConnectionTypeToString(CONNECTION_TYPE) + " connection (" + CStr(Connection.Count) + ")")
            bReturn = FALSE
        end if
    end if
    Wscript.Echo(CStr(Connection.Count) + " objects for connection type " + ConvertConnectionTypeToString(CONNECTION_TYPE))

    GetConnection = bReturn
end function

function ConvertConnectionTypeToString(ConnectionID)
    DIM ConnectionString

    if (ConnectionID = CONNECTION_PUBLIC) then
        ConnectionString = "public"
    elseif (ConnectionID = CONNECTION_PRIVATE) then
        ConnectionString = "private"
    elseif (ConnectionID = CONNECTION_ALL) then
        ConnectionString = "all"
    else
        ConnectionString = "Unknown: " + CStr(ConnectionID)
    end if

    ConvertConnectionTypeToString = ConnectionString
end function
