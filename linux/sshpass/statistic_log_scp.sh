#!/bin/sh
yestoday=$(date  +"%Y_%m_%d" -d  "-1 days")
sshpass -p "hello" scp /Logs/kitchen_db_api_reportvideo_${yestoday}.log root@127.0.0.10:/mnt/task
