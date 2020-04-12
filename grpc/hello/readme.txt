
2020年4月7日 10:35:15
go mod vendor


1,根据helloworld/helloworld.proto生成helloworld.pb.go中间件.

2.greeter_server调用pb.hello中间件,生成服务端.

3.greeter_client调用pb.hello中间件,生成客户端

4.编译生成服务端二进制,cd greeter_server && go build

5.编译生成客户端二进制,cd greeter_client && go build 


