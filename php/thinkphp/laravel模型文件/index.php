<?php

// 补充配置文件
require '/home/ddys_conf/init.php';
require '/git/composer/vendor/autoload.php';

require './articleModel.class.php';

$articleModel = new articleModel();
var_dump($articleModel);

$data = $articleModel::all();
var_dump($data);
