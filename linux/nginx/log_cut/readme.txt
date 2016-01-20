背景
    nginx的日志文件没有rotate功能。一段时间过后，日志将越发臃肿，一个accesslog很快就突破1G，因此有必要通过脚本实现按天切割日志。

 

解决思路
1  重命名日志文件，如更改为access_yyyyMMdd.log，需注意的是nginx通过文件描述符定位日志文件，因此在重命名之后还是能往该文件内写入内容。

 

2  向nginx主进程发送USR1信号。

    nginx的master进程接到信号后：

    重新从配置文件中读取日志文件名 -> 关闭重名日志文件 -> 创建并打开日志文件(原来的名称) -> 通过worker进程作出改变

 

代码实现
A. nginx日志按日期自动切割脚本

复制代码
#author: http://www.nginx.cn
#!/bin/bash
#日志文件存放目录
logs_path="/usr/local/nginx/logs/"
# pid文件
pid_path="/usr/local/nginx/nginx.pid"
#重命名日志文件
mv ${logs_path}access.log ${logs_path}access_$(date -d "yesterday" +"%Y%m%d").log
#向nginx主进程发送信号以重新打开日志
kill -USR1 `cat ${pid_path}
复制代码
保存为 cut-log.sh,

 

B. 设置定时任务 "crontab -e"

0 0 * * * bash /usr/local/nginx/nginx_log.sh
 

将于每天凌晨0点0分将nginx日志重命名为昨天的日期格式，并重新生成今天的新日志
 

 
其他实现
通过apache的rotate程序 + 命名管道的方式
http://blog.chinaunix.net/uid-11121450-id-3177198.html
 
