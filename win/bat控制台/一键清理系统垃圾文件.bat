@echo off
echo 正在清理系统垃圾文件，请稍等......
del /f /s /q %systemdrive%\*.tmp
del /f /s /q %systemdrive%\~*.*
del /f /s /q %systemdrive%\*._mp
del /f /s /q %systemdrive%\*.log
del /f /s /q %systemdrive%\*.gid
del /f /s /q %systemdrive%\*.chk
del /f /s /q %systemdrive%\*.old
del /f /s /q %systemdrive%\recycled\*.*
del /f /s /q %systemdrive%\*.syd
del /f /s /q %systemdrive%\*.spc
del /f /s /q %systemdrive%\*.cdr
del /f /s /q %systemdrive%\*.#res
del /f /s /q %systemdrive%\*.---
del /f /s /q %systemdrive%\*.$$$
del /f /s /q %systemdrive%\*.@@@
del /f /s /q %systemdrive%\*.??$
del /f /s /q %systemdrive%\*.??~
del /f /s /q %systemdrive%\*.~*
del /f /s /q %systemdrive%\mscreate.dir
del /f /s /q %systemdrive%\chklist.*
del /f /s /q %systemdrive%\*.chk
del /f /s /q %systemdrive%\*.ftg
del /f /s /q %systemdrive%\*.fts
del /f /s /q %systemdrive%\*.err
del /f /s /q %systemdrive%\*log.txt
del /f /s /q %systemdrive%\*.prv
del /f /s /q %systemdrive%\*.ms
del /f /s /q %systemdrive%\*.wbk
del /f /s /q %systemdrive%\*.xlk
del /f /s /q %systemdrive%\*.diz
del /f /s /q %systemdrive%\*.dmp
del /f /s /q %systemdrive%\*.db
del /f /s /q %systemdrive%\*.pf
del /f /s /q %windir%\*.bak
del /f /s /q %windir%\*.lnk
del /f /s /q %windir%\prefetch\*.*

del /f /q %userprofile%\cookies\*.txt
del /f /q %userprofile%\recent\*.*
del /f /s /q "%userprofile%\Local Settings\Temporary Internet Files\*.*"
del /f /s /q "%userprofile%\Local Settings\Temp\*.*"
del /f /s /q "%userprofile%\recent\*.*"
echo 恭喜你清理系统垃圾完成!
echo;
echo;

c:
rd recycler /q /s
d:
rd recycler /q /s
e:
rd recycler /q /s
f:
rd recycler /q /s
g:
rd recycler /q /s
h:
rd recycler /q /s





