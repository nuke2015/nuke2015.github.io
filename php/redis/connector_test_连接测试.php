<?php
//实例化
$redis = new Redis();
//连接服务器
$redis->connect("localhosts");
//授权
$redis->auth("123456");
//相关操作
$redis->set("name", "father");
$data = $redis->get("name");
var_dump($data);
