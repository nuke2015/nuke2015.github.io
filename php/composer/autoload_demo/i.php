<?php

// 入口定制
define('ROOT_PATH', dirname(dirname(__DIR__)) . '/');

// 先composer云框架
require_once ROOT_PATH . '/composer/vendor/autoload.php';

$loader = new \Composer\Autoload\ClassLoader();

$loader->setPsr4('feng\\ftest\\','ftest/');

$loader->register(true);

$loader = new Composer\Autoload\ClassLoader();
var_dump(feng\ftest\a::index());

exit;
