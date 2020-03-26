<?php
//加载功能类库
use Illuminate\Database\Capsule\Manager as Capsule;

class Myeloquent extends Illuminate\Database\Eloquent\Model
{
    public static $capsule = null;
    public function __construct()
    {
        if (!self::$capsule) {

            // Eloquent ORM
            $capsule = new Capsule;

            //配置文件
            $conf = ['driver' => 'mysql', 'host' => 'localhost', 'database' => 'test', 'username' => 'root', 'password' => 'root', 'charset' => 'utf8', 'collation' => 'utf8_general_ci', 'prefix' => ''];

            $capsule->addConnection($conf);
            $capsule->bootEloquent();
            self::$capsule = $capsule;
        }
        return;
    }
}
