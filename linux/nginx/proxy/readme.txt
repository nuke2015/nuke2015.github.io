安装
apt-get install nginx,lrzsz

检查
service nginx status

删除
/etc/nginx/sites-enable/default

启动
service nginx restart

检查
netstat -anp|grep 9999

客户端检查
D:\soft\chrome44\chrome.exe --user-data-dir="c:\Cache\g9999" --proxy-server=120.24.171.16:9999
发现http代理是成功的,但是https代理不成功.

查ip
http://ip.cn/
代理成功.

