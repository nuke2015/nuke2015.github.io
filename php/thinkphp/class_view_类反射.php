<?php
require '..\..\config.php';

use didiyuesao\com\model;

$ddys_banner = new model\ddys_banner();
$r           = new ReflectionClass($ddys_banner);
var_dump($r->getConstants(), "Constants");
var_dump($r->getProperties(), "Properties");
var_dump($r->getMethods(), "Methods");
