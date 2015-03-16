<?php

//此shell需要在后台一直监听
error_reporting(2047);

function dump($v) {
    print_r($v);
    echo '<br>';
}

$ip = msg_get_queue(12340);

//创建消息队列，和发送的要一致，不然收不到消息
while (msg_receive($ip, 0, $msgtype, 512, $data, false, null, $err)) {
    echo "mem: " . memory_get_usage() . "\n";
    echo "msgdata: $data\n";
}

