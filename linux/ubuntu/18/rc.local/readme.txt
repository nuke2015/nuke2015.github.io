

这里需要注意一下，ubuntu-18.04 默认是没有 /etc/rc.local 这个文件的，需要自己创建

sudo touch /etc/rc.local
然后把你需要启动脚本写入 /etc/rc.local ，我们不妨写一些测试的脚本放在里面，以便验证脚本是否生效.

echo "this just a test" > /usr/local/text.log
做完这一步，还需要最后一步 前面我们说 systemd 默认读取 /etc/systemd/system 下的配置文件, 所以还需要在 /etc/systemd/system 目录下创建软链接

ln -s /lib/systemd/system/rc.local.service /etc/systemd/system/
OK, 接下来，重启系统，然后看看 /usr/local/text.log 文件是否存在就知道开机脚本是否生效了。

