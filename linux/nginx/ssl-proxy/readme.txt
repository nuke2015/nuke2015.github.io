cd /etc/nginx/
mkdir SSL
cd SSL
openssl genrsa -des3 -out server.key 1024
openssl req -new -key server.key -out server.csr
openssl req -x509 -days 365 -key server.key -in server.csr > server.crt

配置ssl代理

server {
	listen 443;
	ssl on;
	ssl_certificate /etc/nginx/SSL/server.crt;
	ssl_certificate_key /etc/nginx/SSL/server.key;
	server_name proxy.bjdch.org;
	location / {
		#resolver 114.114.114.114;
		resolver 100.100.2.138;
		proxy_pass http://$http_host$uri$is_args$args;
	}
}

#跳转的时候,所有的访问转换成http访问了,因为暂时不知道怎么得到客户端的https这个头,试用了$scheme但是无效.
#以上配置访问是正常的,但是访问不了百度,因为百度限制只能https访问
#阿里云可能限制了外部的dns,所以,如果用内网的dns服务会更快.


启动服务
service nginx restart
会提示要求输入ssl证书的密码

如果密码正确
ps -aux|grep nginx 会有监听进程.

检查
netstat -anp|grep 443有nginx监听


配置stunnel客户端
fips = no

;[cert/key]
key = server.csr

;[SSLv2]
options = NO_SSLv2

[ssl]
client = yes
accept  = 443
connect = 127.0.0.1:443
TIMEOUTclose = 0


