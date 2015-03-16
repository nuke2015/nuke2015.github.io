<?php
error_reporting(2047);

function dump($v) {
    print_r($v);
    echo '<br>';
}

$ip = msg_get_queue(12340);
//创建一个队列
$do=msg_send($ip,1,"Test a message".rand(0,10000),false,false,$err);
var_dump($do);


