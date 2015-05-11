放在/etc/init.d/
要有执行功能chmod +x /etc/init.d/stunneld
然后会用到配置文件在
/etc/stunnel/stunnel.conf
使用
service stunnel start
service stunnel stop
不支持其它,比如status

# chmod 755 /etc/init.d/stunneld 
# chkconfig --add stunneld 
# chkconfig --level 345 stunnel on 
# chkconfig --list stunnel
开机启动
