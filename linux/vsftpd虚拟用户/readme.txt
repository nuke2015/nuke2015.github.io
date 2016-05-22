yum install -y vsftpd db4-utils

在/etc/vsftpd/auth.txt中添加用户和密码
一行用户名,一行密码
db_load -T -t hash -f /etc/vsftpd/auth.txt /etc/vsftpd/auth.db
生成密码数据库
修改/etc/pam.d/vsftpd
#把全部注释,只留下这两行;
auth required /lib/security/pam_userdb.so db=/etc/vsftpd/auth
account required /lib/security/pam_userdb.so db=/etc/vsftpd/auth
#默认使用了ftp用户即可,
如果需要添加,虚拟用户无登陆权限
useradd -d /home/vftpsite/ -s /sbin/nologin vftpuser
chmod 700 /home/vftpsite


注意开通防火墙,否则请关闭iptables.
注意关闭selinux,临时关闭setenforce 0,重启后又失效了.
selinux会导致用户能正常连接ftp,但是不能上传或创建文件.
注意开/var/www/html/用户目录的写权限,否则
注意在pam.d/vsftpd中的配置文件不能带扩展名.db


尚未解决的问题就是iptables开放端口的问题.
#被动模式中必须开放的端口
iptables -A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
iptables -A INPUT -p tcp -m state --state NEW -m tcp --dport 21 -j ACCEPT
iptables -A INPUT -p tcp --dport 2222:2225 -j ACCEPT
#主动模式必须开放的端口
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A INPUT -p tcp  -m multiport --dport 20,21  -m state --state NEW -j ACCEPT
service iptables save
service iptables restart

#ubuntu版本
sudo apt-get install libdb3-util
sudo db3_load -T -t hash -f logins.txt /etc/vsftpd/vsftpd_login.db
sudo chmod 600 /etc/vsftpd/vsftpd_login.db
# This is not safe, you should delete this file.
sudo chmod 600 logins.txt
