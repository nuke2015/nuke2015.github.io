
#启用服务
service crond start

#编辑任务
crontab -e

# vi输入,分分钟执行一次/home/test.sh把结果输出到/home/xxx.log
*/1  *  *  *  *  root  /home/test.sh >> /home/xxx.log
然后保存:wq

#查看任务列表
crontab -l

cd /home
ls


#导出
crontab -l>cronfile.txt
#自动导入定时任务脚本
crontab cronfile

