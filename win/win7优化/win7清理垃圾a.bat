@echo off
echo.下面是可用的变量
Set HomeDrive=C:
Set WinDir=%HomeDrive%\WINDOWS
Set SysDir=%WinDir%\System32
Set ProgFile=%HomeDrive%\Program Files
Set CurUser=%HomeDrive%\Documents and Settings\Administrator
Set AllUser=%HomeDrive%\Documents and Settings\All Users
title=正在清理共享文档...
Rd /s/q "%AllUser%\Documents\My Videos
Rd /s/q "%AllUser%\Documents\My Pictures
Rd /s/q "%AllUser%\Documents\My Music
cls
title=正在清理WMP10目录...
Rd /s/q "%ProgFile%\Windows Media Player\Icons
Rd /s/q "%ProgFile%\Windows Media Player\Sample Playlists
Rd /s/q "%ProgFile%\Windows Media Player\Skins
Rd /s/q "%ProgFile%\Windows Media Player\Visualizations
Del /a/f/s/q "%ProgFile%\Windows Media Player\*.txt
cls
title=正在清理开始菜单...
Del /a/f/s/q "%AllUser%\「开始」菜单\Windows Catalog.*
Del /a/f/s/q "%AllUser%\「开始」菜单\Windows Update.*
Del /a/f/s/q "%AllUser%\「开始」菜单\设定程序访问和默认值.*
cls
title=正在清理360安全卫士目录...
Rd /s/q "%ProgFile%\360Safe\hotfix"
cls
title=正在清理清理ACDSee目录...
Rd /s/q "%CurUser%\Application Data\ACD Systems
Del /a/f/s/q "%ProgFile%\ACDSee\*.hlp"
Del /a/f/s/q "%ProgFile%\ACDSee\*.cnt"
Del /a/f/s/q "%ProgFile%\ACDSee\PlugIns\*.hlp
Del /a/f/s/q "%ProgFile%\ACDSee\PlugIns\*.chm
cls
title=正在清理暴风影音目录...
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.txt
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.ini
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\*.dat
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\GSpot.exe
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\StormSet.exe
Del /a/f/s/q "%ProgFile%\Ringz Studio\Storm Codec\Codecs\languages\ffdshow.1033.en
Rd /s/q "%AllUser%\Application Data\Storm\Update
Rd /s/q "%AllUser%\「开始」菜单\程序\暴风影音
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
title=正在清理 极点五笔 目录...
Rd /s/q "%CurUser%\「开始」菜单\程序\freeime
Del /a/f/s/q "%ProgFile%\freeime\freeime.htm
Del /a/f/s/q "%ProgFile%\freeime\极点五笔 纪念版.url
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
title=正在清理 酷我音乐盒 目录...
Del /a/f/s/q "%CurUser%\Application Data\Microsoft\Internet Explorer\Quick Launch\酷我音乐盒.*
Rd /s/q "%CurUser%\「开始」菜单\程序\酷我音乐盒
Del /a/f/s/q "%ProgFile%\KWMUSIC\readme.txt
cls
title=正在清理 MSOFFICE 目录...
Del /a/f/s/q "%ProgFile%\Microsoft Office\OFFICE11\2052\*.chm
Del /a/f/s/q "%ProgFile%\Microsoft Office\OFFICE11\2052\*.htm
cls
title=正在清理 PPStream 目录...
Del /a/f/q "%AllUser%\「开始」菜单\程序\PPS 网络电视.*
Rd /s/q "%AllUser%\「开始」菜单\程序\PPStream
Del /a/f/s/q "%ProgFile%\PPStream\*.url
Del /a/f/s/q "%ProgFile%\PPStream\whatsnew.txt
cls
title=正在清理 RealPlayer 目录...
Del /a/f/q "%ProgFile%\Real\RealPlayer\Setup\setup.exe"
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.chm
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.txt
Del /a/f/q "%ProgFile%\Real\RealPlayer\*.html
cls
title=正在清理 RealPlayer KoWo 目录...
Rd /s/q "%ProgFile%\KWREAL"
cls
title=正在清理 迅雷 目录...
Del /a/f/q "%ProgFile%\Thunder\AyuConfig.exe
Del /a/f/s/q "%ProgFile%\Thunder Network\Thunder\Program\Update\*.*"
Rd /s/q "%AllUser%\Application Data\Thunder Network\KanKan"
Rd /s/q "%ProgFile%\Thunder Network\Thunder\Components\KanKan"
cls
title=正在清理 WINRAR 目录...
Del /a/f/q "%ProgFile%\WinRAR\*.diz
Del /a/f/q "%ProgFile%\WinRAR\*.txt
Del /a/f/q "%ProgFile%\WinRAR\*.chm
Del /a/f/q "%ProgFile%\WinRAR\*.htm
cls
title=正在清理 千千静听 目录...
Del /a/f/q "%ProgFile%\千千静听\readme.txt
Del /a/f/s/q "%CurUser%\Application Data\Microsoft\Internet Explorer\Quick Launch\千千静听.*
title=正在清理紫光拼音输入法用户词库...
Del /a/f/q "%AllUser%\Application Data\UNISPIM\usrwl.dat"
Del /a/f/q "%CurUser%\Application Data\UNISPIM\usrwl.dat"
cls
title=正在清理超级兔子注册表备份...
Rd /s/q "%WinDir%\MAGICSET"
cls
title=正在清理磁盘检测时生成的损坏文件备份...
Rd /s/q "%HomeDrive%\Found.*"
For /f "delims=\" %%i in ('dir "%HomeDrive%\Found.*" /adh /b') do Rd /s/q "%HomeDrive%\%%i"
cls
title=正在清理虚拟内存文件...
Del /a/f/q "%HomeDrive%\PageFile.sys"
cls
title=正在清理系统休眠文件...
Del /a/f/q "%HomeDrive%\HiberFil.sys"
cls
title=正在清理系统补丁卸载文件...
echo.Rd /s/q "%WinDir%\$*$"
For /f "delims=\" %%i in ('dir "%Windir%\$*$" /adh /b') do Rd /s/q "%WinDir%\%%i"
cls
title=正在清理系统激活程序...
Del /a/f/s/q "%SysDir%\oobe\*.*"
cls
title=正在清理多余鼠标方案...
Del /a/f/s/q "%WinDir%\Cursors\*.*"
cls
title=正在清理系统临时文件...
Del /a/f/s/q "%WinDir%\Temp\*.*"
cls
title=正在清理程序预读文件...
Del /a/f/s/q "%WinDir%\Prefetch\*.*"
cls
title=正在清理驱动预编译文件...
Del /a/f/s/q "%WinDir%\Inf\*.PNF"
cls
echo.清理硬件驱动备份
Del /a/f/s/q "%SysDir%\ReinstallBackups\*.*"
cls
etitle=正在清理 繁体 输入法...
Rd /s/q "%WinDir%\ime\CHTIME"
cls
title=正在清理 日文 输入法...
Rd /s/q "%WinDir%\ime\IMJP8_1"
Rd /s/q "%WinDir%\ime\imejp"
Rd /s/q "%WinDir%\ime\imejp98"
cls
title=正在清理 韩文 输入法...
Rd /s/q "%WinDir%\ime\IMKR6_1"
cls
title=正在清理 繁体 输入法的 手写识别 文件...
Del /a/f/q "%WinDir%\ime\CHTIME\Applets\HWXCHT.DLL"
cls
title=正在清理 仓颉码 输入法...
Rd /s/q "%SysDir%\IME\CINTLGNT"
cls
title=正在清理 注音 输入法...
Rd /s/q "%SysDir%\IME\TINTLGNT"
cls
title=正在清理希腊、土耳其、中欧等字体...
Del /a/f/q "%WinDir%\Fonts\gulim.ttc"
Del /a/f/q "%WinDir%\Fonts\msgothic.ttc"
cls
title=正在清理网页临时文件...
Del /a/f/s/q "%CurUser%\Local Settings\Temporary Internet Files\*.*"
cls
title=正在清理用户临时文件...
Del /a/f/s/q "%CurUser%\Local Settings\Temp\*.*"
cls
title=正在清理网页历史纪录...
Del /a/f/s/q "%CurUser%\Local Settings\History\*.*"
cls
title=正在清理访问过的网络邻居快捷方式...
Del /a/f/s/q "%CurUser%\NetHood\*.*"
cls
title=正在清理未完成的打印任务...
Del /a/f/s/q "%CurUser%\PrintHood\*.*"
cls
title=正在清理最近使用的文档纪录...
Del /a/f/s/q "%CurUser%\Recent\*.*"
cls
title=正在清理网页 Cookie...
Del /a/f/s/q "%CurUser%\Cookies\*.*"
cls
title=正在清理图标缓存文件...
Del /a/f/q "%CurUser%\Local Settings\Application Data\IconCache.db"
cls
title=正在清理无用的 Windows 程序...
Del /a/f/s/q "%ProgFile%\Outlook Express\*.txt
Del /a/f/s/q "%ProgFile%\Online Services\*.*
Rd /s/q "%ProgFile%\Messenger"
Rd /s/q "%ProgFile%\Movie Maker"
Rd /s/q "%ProgFile%\MSN Gaming Zone"
Rd /s/q "%ProgFile%\NetMeeting"
cls
title=正在清理注册表最后一次访问位置...
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Applets\Regedit" /v "LastKey" /t "REG_SZ" /d "我的电脑" /f
cls
title=正在清理注册表中的程序运行记录...
reg delete "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\RunMRU" /f
reg add "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\RunMRU" /f
cls
title=正在清理最后一次正确配置文件...
Rd /s/q "%WinDir%\LastGood"
cls
title=正在清理注册表等文件备份...
Rd /s/q "%WinDir%\Repair"
title=正在清理系统垃圾...
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
