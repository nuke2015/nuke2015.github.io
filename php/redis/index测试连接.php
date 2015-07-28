<?php
$redis = new redis();

//结果：bool(true)
$result = $redis->connect('192.168.1.235', 6379);
var_dump($result);
$set = $redis->set('test', date("Y-m-d H:i:s"));
var_dump($set);
$get = $redis->get('test');
var_dump($get);
