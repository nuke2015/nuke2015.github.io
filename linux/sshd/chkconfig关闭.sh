
#chkconfig iptables off

#apache
chkconfig rsyslog off
chkconfig saslauthd off
chkconfig sendmail off
chkconfig modules_dep off
chkconfig netconsole off
chkconfig netfs off
chkconfig restorecond off
chkconfig rpcbind off

#时间同步
chkconfig ntpd off

#阿里云监控
chkconfig aegis off

#其它
setenforce 0
