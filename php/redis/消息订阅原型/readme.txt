

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

