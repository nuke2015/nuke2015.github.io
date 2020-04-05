
#ddys/build_golang
#admin by jjys168.com
#email:196971567@qq.com

FROM golang:1.12.3-alpine3.9

WORKDIR /app

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories
RUN apk add git

ENV GOPROXY="https://mirrors.aliyun.com/goproxy/" 
ENV GO111MODULE=on 

#RUN GOPROXY="https://mirrors.aliyun.com/goproxy/" GO111MODULE=on go build -o main endgame/main.go
#CMD ["/app/main"]
