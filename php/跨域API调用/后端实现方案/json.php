<?php
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials:true');

// $callback = ($_REQUEST['callback']);

$tmp = array();
$tmp['code'] = 1;
$tmp['msg'] = 'Get is ok!';
$tmp['data'] = $_REQUEST;

$obj = (object)$tmp;
$json = json_encode($obj);
echo $json;
// echo "$callback($json);";
exit;
