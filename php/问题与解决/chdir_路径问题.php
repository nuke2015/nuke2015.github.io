<?php

//常量定义;
$sep = DIRECTORY_SEPARATOR;
define('FILE_ROOT', dirname(dirname(dirname(__FILE__))) . $sep);
define('MODULE_PATH', FILE_ROOT . "web{$sep}api{$sep}dianping{$sep}");
define('METHOD_NAME', $methodName);

//解决路径include问题.
chdir(FILE_ROOT);

