<?php

/**
 * 模拟短信发送器
 */
send_mms($_POST);

function send_mms($data) {
    
    //假如,在发短信的时候,短信网关故障,等待了很长时间.
    sleep(10);
    
    $data['time'] = time();
    
    //写个日志,跟踪脚本有没有执行.
    file_put_contents('x.log', json_encode($data) . "\r\n", FILE_APPEND);
}
echo 'done!';

