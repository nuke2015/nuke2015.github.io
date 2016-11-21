
安装virtualbox+vagrant启动虚拟机

启动
vagrant up

进入虚拟机领空
vagrant ssh
 
修改密码
sudo passwd root
su
vi /etc/ssh/sshd_config
把登陆
PermitRootLogin prohibit-password
改成
PermitRootLogin yes
service ssh restart
ssh root@127.0.0.1
测试一下

