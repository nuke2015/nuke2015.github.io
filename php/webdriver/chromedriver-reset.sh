#! /bin/sh

ps -ef|grep chromedriver|awk '{print $2}'|xargs kill -9

nohup /usr/lib/chromium-browser/chromedriver -p 9515 &

