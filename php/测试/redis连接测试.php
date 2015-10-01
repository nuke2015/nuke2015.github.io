<?php
$redis = new redis();
var_dump($redis);

//结果：bool(true)
$result = $redis->connect('127.0.0.1', 6379);
var_dump($result);
$set = $redis->set('test', date("Y-m-d H:i:s"));
var_dump($set);
$get = $redis->get('test');
var_dump($get);


