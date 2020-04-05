
#ddys/build_nodejs
#admin by jjys168.com
#email:196971567@qq.com

FROM node:12-alpine as builder
MAINTAINER Nuke2015 <196971567@qq.com>

#aliyun 
ADD repositories /etc/apk/repositories

RUN apk add --no-cache git python make openssl tar gcc

RUN cd /home && npm install --production --registry https://registry.npm.taobao.org



