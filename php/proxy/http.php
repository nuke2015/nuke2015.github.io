<?php
error_reporting(2);
date_default_timezone_set('PRC');
if (!is_dir('./runtime/')) {
    mkdir('./runtime', 0777);
}

require '\..\..\..\code\dev\composer\vendor\autoload.php';

// var_dump('feng proxy');exit;

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$REQUEST_URI    = $_SERVER['REQUEST_URI'];
vlog('brower', [date('Y-m-d H:i:s'), $REQUEST_METHOD, $REQUEST_URI, $_SERVER, $_REQUEST]);

const PROXY_HOST = 'http://127.0.0.1:8061/';
$header          = array();
// $header['Accept-Language']                          = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$header['Accept-Encoding']                                      = $_SERVER['HTTP_ACCEPT_ENCODING'];
isset($_SERVER['HTTP_CONTENT_TYPE']) && $header['Content-type'] = $_SERVER['HTTP_CONTENT_TYPE'];
$header['Host']                                                 = $_SERVER['HTTP_HOST'];
$header['User-Agent']                                           = $_SERVER['HTTP_USER_AGENT'];
isset($_SERVER['HTTP_COOKIE']) && $header['Cookie']             = $_SERVER['HTTP_COOKIE'];
if (isset($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'])) {
    $header['Upgrade-Insecure-Requests'] = $_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'];
}
//片段
if (isset($_SERVER['range'])) {
    $header['Range'] = $_SERVER['HTTP_RANGE'];
}

$req = [$REQUEST_URI, $REQUEST_METHOD, $_REQUEST, $header];
vlog('req', $req);

$REQUEST_URI = urldecode($REQUEST_URI);

if (strtolower($REQUEST_METHOD) == 'get') {
    //get
    $data = org\myhttp::curl($REQUEST_URI, $REQUEST_METHOD, [], $header);
} else {
    // post other
    $data = org\myhttp::curl($REQUEST_URI, $REQUEST_METHOD, $_REQUEST, $header);
}
// 独立提取请求头
list($do, $info) = org\myhttp::header();
vlog('res', [$REQUEST_URI, $info, $data]);
if ($info && count($info) && $data) {
    header('Content-Type:' . $info['content_type']);
    echo $data;
}

exit;

// 日志
function vlog($filename, $data)
{
    $str = print_r($data, 1) . "\r\n";
    file_put_contents('./runtime/log_' . $filename . '.log', $str, FILE_APPEND);
}
