<?php

/**
 * 短信发送器
 */
send_mms($_POST);

function send_mms($data) {
    sleep(10);
    $data['time'] = time();
    file_put_contents('x.log', json_encode($data) . "\r\n", FILE_APPEND);
}
echo 'done!';

