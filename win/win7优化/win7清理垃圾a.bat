@echo off
echo.�����ǿ��õı���
Set HomeDrive=C:
Set WinDir=%HomeDrive%\WINDOWS
Set SysDir=%WinDir%\System32
Set ProgFile=%HomeDrive%\Program Files
Set CurUser=%HomeDrive%\Documents and Settings\Administrator
Set AllUser=%HomeDrive%\Documents and Settings\All Users
title=�����������ĵ�...
Rd /s/q "%AllUser%\Documents\My Videos
Rd /s/q "%AllUser%\Documents\My Pictures
Rd /s/q "%AllUser%\Documents\My Music
cls
title=��������WMP10Ŀ¼...
Rd /s/q "%ProgFile%\Windows Media Player\Icons
Rd /s/q "%ProgFile%\Windows Media Player\Sample Playlists
Rd /s/q "%ProgFile%\Windows Media Player\Skins
Rd /s/q "%ProgFile%\Windows Media Player\Visualizations
Del /a/f/s/q "%ProgFile%\Windows Media Player\*.txt
cls
title=��������ʼ�˵�...
Del /a/f/s/q "%AllUser%\����ʼ���˵�\Windows Catalog.*
Del /a/f/s/q "%AllUser%\����ʼ���˵�\Windows Update.*
Del /a/f/s/q "%AllUser%\����ʼ���˵�\�趨������ʺ�Ĭ��ֵ.*
cls
title=��������360��ȫ��ʿĿ¼...
Rd /s/q "%ProgFile%\360Safe\hotfix"
cls
title=������������ACDSeeĿ¼...
Rd /s/q "%CurUser%\Application Data\ACD Systems
Del /a/f/s/q "%ProgFile%\ACDSee\*.hlp"
Del /a/f/s/q "%ProgFile%\ACDSee\*.cnt"
Del /a/f/s/q "%ProgFile%\ACDSee\PlugIns\*.hlp
Del /a/f/s/q "%ProgFile%\ACDSee\PlugIns\*.chm
cls
title=����������Ӱ��Ŀ¼...
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.txt
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.ini
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.dat
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\GSpot.exe
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\StormSet.exe
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\Codecs\languages\ffdshow.1033.en
Rd /s/q "%AllUser%\Application Data\Storm\Update
Rd /s/q "%AllUser%\����ʼ���˵�\����\����Ӱ��
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\CoreVideo.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTime3GPP.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTime.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeAudioSupport.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeEssentials.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeH264.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeInternetExtras.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeMPEG4.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeStreaming.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeStreamingExtras.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeVR.Resources\en.lproj
Rd /s/q "%ProgFile%\Ringz Studio\Storm Codec\QTSystem\QuickTimeWebHelper.Resources\en.lproj
cls
title=�������� ������� Ŀ¼...
Rd /s/q "%CurUser%\����ʼ���˵�\����\freeime
Del /a/f/s/q "%ProgFile%\freeime\freeime.htm
Del /a/f/s/q "%ProgFile%\freeime\������� �����.url
Del /a/f/s/q "%ProgFile%\freeime\*.gif
Del /a/f/s/q "%ProgFile%\freeime\*.txt
Rd /s/q "%ProgFile%\freeime\skin\Apple_Z
Rd /s/q "%ProgFile%\freeime\skin\bear2
Rd /s/q "%ProgFile%\freeime\skin\Elegant
Rd /s/q "%ProgFile%\freeime\skin\IF_Taiji
Rd /s/q "%ProgFile%\freeime\skin\time
Rd /s/q "%ProgFile%\freeime\skin\du
Rd /s/q "%ProgFile%\freeime\skin\huan
Rd /s/q "%ProgFile%\freeime\skin\Tango NightXP
Rd /s/q "%ProgFile%\freeime\skin\youxihou
Rd /s/q "%ProgFile%\freeime\skin\blueness
Rd /s/q "%ProgFile%\freeime\skin\Hello Kitty
Rd /s/q "%ProgFile%\freeime\skin\MG_S
Rd /s/q "%ProgFile%\freeime\skin\VistaHeiMini
cls
title=�������� �������ֺ� Ŀ¼...
Del /a/f/s/q "%CurUser%\Application Data\Microsoft\Internet Explorer\Quick Launch\�������ֺ�.*
Rd /s/q "%CurUser%\����ʼ���˵�\����\�������ֺ�
Del /a/f/s/q "%ProgFile%\KWMUSIC\readme.txt
cls
title=�������� MSOFFICE Ŀ¼...
Del /a/f/s/q "%ProgFile%\Microsoft Office\OFFICE11\2052\*.chm
Del /a/f/s/q "%ProgFile%\Microsoft Office\OFFICE11\2052\*.htm
cls
title=�������� PPStream Ŀ¼...
Del /a/f/q "%AllUser%\����ʼ���˵�\����\PPS �������.*
Rd /s/q "%AllUser%\����ʼ���˵�\����\PPStream
Del /a/f/s/q "%ProgFile%\PPStream\*.url
Del /a/f/s/q "%ProgFile%\PPStream\whatsnew.txt
cls
title=�������� RealPlayer Ŀ¼...
Del /a/f/q "%ProgFile%\Real\RealPlayer\Setup\setup.exe"
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.chm
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.txt
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.html
cls
title=�������� RealPlayer KoWo Ŀ¼...
Rd /s/q "%ProgFile%\KWREAL"
cls
title=�������� Ѹ�� Ŀ¼...
Del /a/f/q "%ProgFile%\Thunder\AyuConfig.exe
Del /a/f/s/q "%ProgFile%\Thunder Network\Thunder\Program\Update\*.*"
Rd /s/q "%AllUser%\Application Data\Thunder Network\KanKan"
Rd /s/q "%ProgFile%\Thunder Network\Thunder\Components\KanKan"
cls
title=�������� WINRAR Ŀ¼...
Del /a/f/q "%ProgFile%\WinRAR\*.diz
Del /a/f/q "%ProgFile%\WinRAR\*.txt
Del /a/f/q "%ProgFile%\WinRAR\*.chm
Del /a/f/q "%ProgFile%\WinRAR\*.htm
cls
title=�������� ǧǧ���� Ŀ¼...
Del /a/f/q "%ProgFile%\ǧǧ����\readme.txt
Del /a/f/s/q "%CurUser%\Application Data\Microsoft\Internet Explorer\Quick Launch\ǧǧ����.*
title=���������Ϲ�ƴ�����뷨�û��ʿ�...
Del /a/f/q "%AllUser%\Application Data\UNISPIM\usrwl.dat"
Del /a/f/q "%CurUser%\Application Data\UNISPIM\usrwl.dat"
cls
title=��������������ע�����...
Rd /s/q "%WinDir%\MAGICSET"
cls
title=����������̼��ʱ���ɵ����ļ�����...
Rd /s/q "%HomeDrive%\Found.*"
For /f "delims=\" %%i in ('dir "%HomeDrive%\Found.*" /adh /b') do Rd /s/q "%HomeDrive%\%%i"
cls
title=�������������ڴ��ļ�...
Del /a/f/q "%HomeDrive%\PageFile.sys"
cls
title=��������ϵͳ�����ļ�...
Del /a/f/q "%HomeDrive%\HiberFil.sys"
cls
title=��������ϵͳ����ж���ļ�...
echo.Rd /s/q "%WinDir%\$*$"
For /f "delims=\" %%i in ('dir "%Windir%\$*$" /adh /b') do Rd /s/q "%WinDir%\%%i"
cls
title=��������ϵͳ�������...
Del /a/f/s/q "%SysDir%\oobe\*.*"
cls
title=�������������귽��...
Del /a/f/s/q "%WinDir%\Cursors\*.*"
cls
title=��������ϵͳ��ʱ�ļ�...
Del /a/f/s/q "%WinDir%\Temp\*.*"
cls
title=�����������Ԥ���ļ�...
Del /a/f/s/q "%WinDir%\Prefetch\*.*"
cls
title=������������Ԥ�����ļ�...
Del /a/f/s/q "%WinDir%\Inf\*.PNF"
cls
echo.����Ӳ����������
Del /a/f/s/q "%SysDir%\ReinstallBackups\*.*"
cls
etitle=�������� ���� ���뷨...
Rd /s/q "%WinDir%\ime\CHTIME"
cls
title=�������� ���� ���뷨...
Rd /s/q "%WinDir%\ime\IMJP8_1"
Rd /s/q "%WinDir%\ime\imejp"
Rd /s/q "%WinDir%\ime\imejp98"
cls
title=�������� ���� ���뷨...
Rd /s/q "%WinDir%\ime\IMKR6_1"
cls
title=�������� ���� ���뷨�� ��дʶ�� �ļ�...
Del /a/f/q "%WinDir%\ime\CHTIME\Applets\HWXCHT.DLL"
cls
title=�������� ����� ���뷨...
Rd /s/q "%SysDir%\IME\CINTLGNT"
cls
title=�������� ע�� ���뷨...
Rd /s/q "%SysDir%\IME\TINTLGNT"
cls
title=��������ϣ���������䡢��ŷ������...
Del /a/f/q "%WinDir%\Fonts\gulim.ttc"
Del /a/f/q "%WinDir%\Fonts\msgothic.ttc"
cls
title=����������ҳ��ʱ�ļ�...
Del /a/f/s/q "%CurUser%\Local Settings\Temporary Internet Files\*.*"
cls
title=���������û���ʱ�ļ�...
Del /a/f/s/q "%CurUser%\Local Settings\Temp\*.*"
cls
title=����������ҳ��ʷ��¼...
Del /a/f/s/q "%CurUser%\Local Settings\History\*.*"
cls
title=����������ʹ��������ھӿ�ݷ�ʽ...
Del /a/f/s/q "%CurUser%\NetHood\*.*"
cls
title=��������δ��ɵĴ�ӡ����...
Del /a/f/s/q "%CurUser%\PrintHood\*.*"
cls
title=�����������ʹ�õ��ĵ���¼...
Del /a/f/s/q "%CurUser%\Recent\*.*"
cls
title=����������ҳ Cookie...
Del /a/f/s/q "%CurUser%\Cookies\*.*"
cls
title=��������ͼ�껺���ļ�...
Del /a/f/q "%CurUser%\Local Settings\Application Data\IconCache.db"
cls
title=�����������õ� Windows ����...
Del /a/f/s/q "%ProgFile%\Outlook Express\*.txt
Del /a/f/s/q "%ProgFile%\Online Services\*.*
Rd /s/q "%ProgFile%\Messenger"
Rd /s/q "%ProgFile%\Movie Maker"
Rd /s/q "%ProgFile%\MSN Gaming Zone"
Rd /s/q "%ProgFile%\NetMeeting"
cls
title=��������ע������һ�η���λ��...
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Applets\Regedit" /v "LastKey" /t "REG_SZ" /d "�ҵĵ���" /f
cls
title=��������ע����еĳ������м�¼...
reg delete "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\RunMRU" /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\RunMRU" /f
cls
title=�����������һ����ȷ�����ļ�...
Rd /s/q "%WinDir%\LastGood"
cls
title=��������ע�����ļ�����...
Rd /s/q "%WinDir%\Repair"
title=��������ϵͳ����...
Del /a/f/s/q "%HomeDrive%\*.tmp"
Del /a/f/s/q "%HomeDrive%\*._mp"
Del /a/f/s/q "%HomeDrive%\*.log"
Del /a/f/s/q "%HomeDrive%\*.gid"
Del /a/f/s/q "%HomeDrive%\*.chk"
Del /a/f/s/q "%HomeDrive%\*.old"
Rd /s/q "%HomeDrive%\RECYCLER
Rd /s/q "%HomeDrive%\System Volume Information
Del /a/f/s/q "%WinDir%\*.bak"
Rd /s/q "%WinDir%\assembly
del /f /s /q "%WinDir%\SoftwareDistribution\Download\*.*
del /f /s /q "%WinDir%\inf\*.pnf
del /f /s /q %SysDir%\CatRoot2\tmp.ed0
del /f /s /q %SysDir%\spool\drivers\w32x86\3\*.*
del /f /s /q %SysDir%\*.tmp
del /f /s /q %SysDir%\*._mp
del /f /s /q %SysDir%\*.log
del /f /s /q %SysDir%\*.gid
del /f /s /q %SysDir%\*.chk
del /f /s /q %SysDir%\*.old
del /f /s /q %SysDir%%\recycled\*.*
exit 
