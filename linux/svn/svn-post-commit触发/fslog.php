<?php


logme($argv);
var_dump($argv);

/**
 * 日志;
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function logme($data){
    $result=date('Y/m/d H:i:s',time());
    $result.="\r\n";
    $result.=print_r($data,1);
    $result.="\r\n";
    $filename='d:/fslog.log';
    file_put_contents($filename,$result,FILE_APPEND);
}

