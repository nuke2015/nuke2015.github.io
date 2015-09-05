#清空旧规则
iptables -F
iptables -X
iptables -Z
#以下规则会锁自己
#iptables -P INPUT DROP
#iptables -P FORWARD DROP
#iptables -P OUTPUT DROP
##屏避指定IP,注意网卡编号venet0/venet0
#iptables -A INPUT -i venet0 -s "$BLOCK_THIS_IP" -j DROP
##仅屏蔽来自该IP的TCP数据包
#iptables -A INPUT -i venet0 -p tcp -s "$BLOCK_THIS_IP" -j DROP
#允许外部ping本机
iptables -A INPUT -p icmp --icmp-type echo-request -j ACCEPT
iptables -A OUTPUT -p icmp --icmp-type echo-reply -j ACCEPT
#允许本机ping外部
iptables -A OUTPUT -p icmp --icmp-type echo-request -j ACCEPT
iptables -A INPUT -p icmp --icmp-type echo-reply -j ACCEPT
#允许本机回环
iptables -A INPUT -i lo -j ACCEPT
iptables -A OUTPUT -o lo -j ACCEPT
##端口控制
#开放外部到本机sshd-8888端口.注意venet0是网卡号
iptables -A INPUT -i venet0 -p tcp --dport 8888 -m state --state NEW,ESTABLISHED -j ACCEPT
iptables -A OUTPUT -o venet0 -p tcp --sport 8888 -m state --state ESTABLISHED -j ACCEPT
#开放外部到本机http-8080端口
iptables -A INPUT -i venet0 -p tcp --dport 8080 -m state --state NEW,ESTABLISHED -j ACCEPT
iptables -A OUTPUT -o venet0 -p tcp --sport 8080 -m state --state ESTABLISHED -j ACCEPT
#开放本机到外部http-80端口
iptables -A OUTPUT -o venet0 -p tcp --dport 80 -m state --state NEW,ESTABLISHED -j ACCEPT
iptables -A INPUT -i venet0 -p tcp --sport 80 -m state --state ESTABLISHED -j ACCEPT
#开放外部到本机https-443端口
#iptables -A INPUT -i venet0 -p tcp --dport 443 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 443 -m state --state ESTABLISHED -j ACCEPT
#开放本机到外部https-443端口
#iptables -A OUTPUT -o venet0 -p tcp --dport 443 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A INPUT -i venet0 -p tcp --sport 443 -m state --state ESTABLISHED -j ACCEPT
#开放外部到本机stunnel-3016端口
#iptables -A INPUT -i venet0 -p tcp --dport 3016 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 3016 -m state --state ESTABLISHED -j ACCEPT
#允许指定子网的sshd到本机;
#iptables -A INPUT -i venet0 -p tcp -s 192.168.100.0/24 --dport 22 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 22 -m state --state ESTABLISHED -j ACCEPT
#允许本机到指定网络的sshd
#iptables -A OUTPUT -o venet0 -p tcp -d 192.168.100.0/24 --dport 22 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A INPUT -i venet0 -p tcp --sport 22 -m state --state ESTABLISHED -j ACCEPT
#同时开放多个端口
#iptables -A INPUT -i venet0 -p tcp -m multiport --dports 22,80,443 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp -m multiport --sports 22,80,443 -m state --state ESTABLISHED -j ACCEPT
##开放本机到外部的DNS-53
#iptables -A OUTPUT -p udp -o venet0 --dport 53 -j ACCEPT
#iptables -A INPUT -p udp -i venet0 --sport 53 -j ACCEPT
#允许外部到机的NIS-ypbind-111+853+850
#iptables -A INPUT -p tcp --dport 111 -j ACCEPT
#iptables -A INPUT -p udp --dport 111 -j ACCEPT
#iptables -A INPUT -p tcp --dport 853 -j ACCEPT
#iptables -A INPUT -p udp --dport 853 -j ACCEPT
#iptables -A INPUT -p tcp --dport 850 -j ACCEPT
#iptables -A INPUT -p udp --dport 850 -j ACCEPT
#允许指定的子网rsync到本机873,同步备份
#iptables -A INPUT -i venet0 -p tcp -s 192.168.101.0/24 --dport 873 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 873 -m state --state ESTABLISHED -j ACCEPT
#允许指定子网的mysql到本机3306,数据库
#iptables -A INPUT -i venet0 -p tcp -s 192.168.100.0/24 --dport 3306 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 3306 -m state --state ESTABLISHED -j ACCEPT
#允许外部sendmail/postfix到本机的25,邮件服务发送
#iptables -A INPUT -i venet0 -p tcp --dport 25 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 25 -m state --state ESTABLISHED -j ACCEPT
#允许外部IMAP到本机的143,邮件服务
#iptables -A INPUT -i venet0 -p tcp --dport 143 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 143 -m state --state ESTABLISHED -j ACCEPT
#允许外部IMAPS到本机的993,邮件服务加密
#iptables -A INPUT -i venet0 -p tcp --dport 993 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 993 -m state --state ESTABLISHED -j ACCEPT
#允许外部POP3到本机的110,邮件服务
#iptables -A INPUT -i venet0 -p tcp --dport 110 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 110 -m state --state ESTABLISHED -j ACCEPT
#允许外部POP3S到本机的995,邮件服务加密
#iptables -A INPUT -i venet0 -p tcp --dport 995 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 995 -m state --state ESTABLISHED -j ACCEPT

#防止DDOS攻击,当洪水达到100条连接时,限制每分钟25个连接.超过就扔.
#iptables -A INPUT -p tcp --dport 80 -m limit --limit 25/minute --limit-burst 100 -j ACCEPT

##路由与转发
#Nat转发
#iptables -A FORWARD -i venet0 -o eth1 -j ACCEPT
# 1.开放外部NAT到本机的442,透明代理
#iptables -A INPUT -i venet0 -p tcp --dport 422 -m state --state NEW,ESTABLISHED -j ACCEPT
#iptables -A OUTPUT -o venet0 -p tcp --sport 422 -m state --state ESTABLISHED -j ACCEPT
# 2.启用DNAT转发
#iptables -t nat -A PREROUTING -p tcp -d 192.168.102.37 --dport 422 -j DNAT --to-destination 192.168.102.37:22
#外部Nat到本机8888,转发到子网192.168.0.2:80,反向透明代理
#iptables -t nat -A PREROUTING -p tcp -i venet0 -d xxx.xxx.xxx.xxx --dport 8888 -j DNAT --to 192.168.0.2:80
#iptables -A FORWARD -p tcp -i venet0 -d 192.168.0.2 --dport 80 -j ACCEPT
#本机代理子网对外,snat_静态源地址_伪装;
#iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o venet0 -j snat --to-source 192.168.5.3
##本机代理子网对外,snat_动态(ADSL)_伪装;
#iptables -t nat -A POSTROUTING -s 10.8.0.0/255.255.255.0 -o venet0 -j MASQUERADE
#负载均衡,服务器集群;
#iptables -A PREROUTING -i venet0 -p tcp --dport 443 -m state --state NEW -m nth --counter 0 --every 3 --packet 0 -j DNAT --to-destination 192.168.1.101:443
#iptables -A PREROUTING -i venet0 -p tcp --dport 443 -m state --state NEW -m nth --counter 0 --every 3 --packet 1 -j DNAT --to-destination 192.168.1.102:443
#iptables -A PREROUTING -i venet0 -p tcp --dport 443 -m state --state NEW -m nth --counter 0 --every 3 --packet 2 -j DNAT --to-destination 192.168.1.103:443
##自定义连接监控(非法访问记录等)
# 1.新建名为LOGGING的链
#iptables -N LOGGING
# 2.将所有来自INPUT链中的数据包跳转到LOGGING链中
#iptables -A INPUT -j LOGGING
# 3.指定自定义的日志前缀"IPTables Packet Dropped: "
#iptables -A LOGGING -m limit --limit 2/min -j LOG --log-prefix "IPTables Packet Dropped: " --log-level 7
# 4.丢弃这些数据包
#iptables -A LOGGING -j DROP

#其它未涉及的服务与端口,全部拒绝;
iptables -A INPUT -j REJECT
iptables -A FORWARD -j REJECT
iptables -A OUTPUT -j REJECT

#保存重启
service iptables save
service iptables restart
