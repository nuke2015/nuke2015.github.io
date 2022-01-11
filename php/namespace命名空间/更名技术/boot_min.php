<?php

// 只适用于php7.0版本.
if (!defined('CUBE_COMPOSER')) {
    define('CUBE_COMPOSER', '/git/composer/');
}

// 先composer云框架
require_once CUBE_COMPOSER . '/vendor/autoload.php';

// didiyuesao boot 
// require_once __DIR__ . '/didiyuesao_autoload.php';

// var_dump(class_exists('\nuke2015\api\org\TError'));
// class_alias('\nuke2015\api\org\TError','bbb'); 

// $x=new \nuke2015\api\org\TError();
// var_dump($x);
// exit;


// var_dump(class_exists('\nuke2015\api\org\TError'));
// class_alias('\nuke2015\api\org\TError','bbb'); 

// $x=new bbb();
// var_dump($x);
// exit;


// var_dump(class_exists('\nuke2015\api\org\TError'));
// class_alias('\nuke2015\api\org\TError','didiyuesao\com\org\TError'); 

// $x=new \didiyuesao\com\org\TError();
// var_dump($x);
// exit;

var_dump(class_exists('\nuke2015\api\org\TError'));
class_alias('\nuke2015\api\org\TError','didiyuesao\com\org\TError'); 

// $x=new \didiyuesao\com\org\TError();
// var_dump($x);
// exit;




use nuke2015\api\base as base;
use nuke2015\api\org as org;
spl_autoload_register(function($class_name){
    // $check=stripos($class_name, 'didiyuesao\com\org');
    // if($check!==false){
        
    //     $other=substr($class_name, 19);
    //     return "org\\$other";        
    //     // class_alias('didiyuesao\com\org',$map);   
    // var_dump($check,$other);
    // }
    var_dump('nnn feng.'.$class_name);
});


