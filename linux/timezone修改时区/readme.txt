
6.复制文件到/etc目录下
sudo cp /usr/share/zoneinfo/Asia/Shanghai  /etc/localtime

7.更新时间
sudo ntpdate time.windows.com

检查
echo $(date)

得到的是当前时间.

我用的是lrzsz覆盖,注意检查,覆盖后文件权限是否一致

