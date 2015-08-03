把json.php放在服务器上,绑定域名或直接用ip访问.
把index.html放在本地127.0.0.1上.
修改index.html中的url地址,指向服务器.
直接访问http://xxx.com/json.php能访问表示网络连接正常.

然后访问127.0.0.1弹出get is ok!表示,跨域成功.
用chrome查看console,会看到有个数据对象.

注意:
如果json.php和index.html放在同一个域名下,就叫ajax请求,和跨域无关.

