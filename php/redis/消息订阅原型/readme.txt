

启动redis做为通道服务

然后
php sub.php abc.tv
订阅者一
php sub.php abc.tv
订阅者二

php pub.php abc.tv hello
发布者
所有订阅abc.tv的人都将收到hello

注意:
这种简单的方式不能有空格,这是php从bat取参数引起的.
解决办法
php pub.php abc.tv "hello abc,this is feng"

php做为消息的发布者,用nodejs+forever做守护进程,
做消息的订阅者,一个完美的消息队列服务就有了.
最重要的是php中全程共享一个redis句柄,
所以,减少了日志入数据库的连接数.减少了日志直接写文件的io开销.

