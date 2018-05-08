

@echo off

rem 设置ADSL名称,帐号,密码
set adslmingzi=ADSL名称
set adslzhanghao=上网的帐号
set adslmima=密码

:start

rem 连接
Rasdial %adslmingzi% %adslzhanghao% %adslmima%
echo 连接中

rem 你的IP
ipconfig

rem 延时10秒,-n后面的10代表10秒,可以自己修改.
ping 127.0.0.1 -n 10

rem 断开连接
Rasdial %adslmingzi% /disconnect
echo 断开连接

rem 延时5秒,-n后面的5代表5秒,可以自己修改.
ping 127.0.0.1 -n 5

rem 循环
goto start



