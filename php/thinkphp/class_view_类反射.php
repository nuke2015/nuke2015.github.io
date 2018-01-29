<?php
require '..\..\config.php';

use didiyuesao\com\model;

$ddys_banner = new model\ddys_banner();
$r           = new ReflectionClass($ddys_banner);
var_dump($r->getConstants(), "Constants");
var_dump($r->getProperties(), "Properties");

$ary = $r->getMethods();
var_dump($ary, "methods");

foreach ($ary as $key => $method) {
    $classMethod   = new ReflectionMethod($ddys_banner, $method->name);
    $argumentCount = count($classMethod->getParameters());
    var_dump($method->name . " args_count:" . $argumentCount);
}
