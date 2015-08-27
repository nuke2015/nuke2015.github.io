<?php
ini_set('memory_limit', '1M');
set_time_limit(3600);

while (1) {
    echo "heartbeat start... \r\n";
    try {
        notice();
        loger('success');
    }
    catch(Exception $e) {
        loger('error');
    }
    echo "heartbeat stop! \r\n\r\n";
}

//这是主线程日志
function loger($str) {
    echo "{$str}\r\n";
}

//触发器
function notice() {
    echo "working\r\n";
    
    // $ch = curl_init('http://example.com/');
    $ch = curl_init('http://127.0.0.4/mms.php');
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    
    //以head的方式请求,流量 消耗非常小!
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    print_r(curl_getinfo($ch));
    curl_close($ch);
    
    //制造意外
    $status = rand(0, 1);
    if (!$status) throw new Exception('error');
}
