<?php
namespace app\api\model;

class User extends \think\Model
{
     protected static $table = 'user';

     public static function hello(){
        echo 'user/model/hello';
        exit;
     }
}
