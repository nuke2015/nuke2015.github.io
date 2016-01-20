#author: http://www.nginx.cn
#!/bin/bash
#日志文件存放目录
logs_path="/kitchen/var/"
# pid文件
pid_path="/run/nginx.pid"

file=${logs_path}nginx_access.log
if [ -f "$file" ]
then
	#重命名日志文件
	mv ${logs_path}nginx_access.log ${logs_path}nginx_access_$(date -d "yesterday" +"%Y%m%d").log
	#向nginx主进程发送信号以重新打开日志
	kill -USR1 $(cat ${pid_path})
fi

## 要注意各种配置的路径是否存在.nginx本身不支持日志切割,所以,只能用这种土办法了.
