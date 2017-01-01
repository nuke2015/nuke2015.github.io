
2017年1月1日 14:21:58
http报文抓包
php -S 127.0.0.2:80开启监听.
然后把chrome代理指向对应端口.
D:\soft\chrome\chrome.exe --user-data-dir="D:\Cache\c1066" --proxy-server=127.0.0.2:80
访问可得到相关的报文都在$_SERVER变量里.

