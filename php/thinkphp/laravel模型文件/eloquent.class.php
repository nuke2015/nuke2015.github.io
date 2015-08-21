<?php

//配置文件
$db['eloquent'] = ['driver' => 'mysql', 'host' => 'localhost', 'database' => 'testdb', 'username' => 'root', 'password' => '', 'charset' => 'utf8', 'collation' => 'utf8_general_ci', 'prefix' => ''];

//加载功能类库
use Illuminate\Database\Capsule\Manager as Capsule;

// Autoload 自动载入
require __DIR__ . '/vendor/autoload.php';

// Eloquent ORM
$capsule = new Capsule;

$capsule->addConnection($db['eloquent']);

$capsule->bootEloquent();

