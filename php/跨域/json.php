<?php
header('Content-type: application/json');
$callback = ($_REQUEST['callback']);

$tmp = array();
$tmp['code'] = 1;
$tmp['msg'] = 'Get is ok!';
$tmp['data'] = $_REQUEST;

$obj = (object)$tmp;
$json = json_encode($obj);
echo "$callback($json);";
exit;
