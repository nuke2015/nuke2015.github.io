<?php

//加载功能类库
use Illuminate\Database\Capsule\Manager as Capsule;

// Autoload 自动载入
require_once __DIR__ . '/vendor/autoload.php';

class eloquent extends Illuminate\Database\Eloquent\Model
{
    public static $capsule = null;
    public function __construct() {
        if (!self::$capsule) {
            
            // Eloquent ORM
            $capsule = new Capsule;
            
            //配置文件
            $db['eloquent'] = ['driver' => 'mysql', 'host' => 'localhost', 'database' => 'testdb', 'username' => 'root', 'password' => '', 'charset' => 'utf8', 'collation' => 'utf8_general_ci', 'prefix' => ''];
            
            $capsule->addConnection($db['eloquent']);
            $capsule->bootEloquent();
            self::$capsule = $capsule;
        }
        return;
    }
}
