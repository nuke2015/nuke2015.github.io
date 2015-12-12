

系统更新
sudo apt-get update && sudo apt-get upgrade

安装nginx
service --status-all|grep nginx
apt-get install nginx -y


# installs add-apt-repository

sudo apt-get install -y software-properties-common

sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449

sudo add-apt-repository "deb http://mirrors.hypo.cn/hhvm/ubuntu $(lsb_release -sc) main"

sudo apt-get update

sudo apt-get install -y hhvm


安装为nginx扩展
sudo /usr/share/hhvm/install_fastcgi.sh

服务重启
sudo /etc/init.d/hhvm restart
sudo /etc/init.d/nginx restart

开机启动
sudo update-rc.d hhvm defaults


用hhvm取代命令行php-cli
sudo /usr/bin/update-alternatives \
   --install /usr/bin/php php /usr/bin/hhvm 60

参考:
https://github.com/facebook/hhvm/wiki/FastCGI


