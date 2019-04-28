<?php
namespace app\index\controller;

use think\Cookie;

class Index
{
    public function index()
    {

        // cookie初始化
        Cookie::init(['prefix' => 'think_', 'expire' => 3600, 'path' => '/']);

        // 指定当前前缀
        Cookie::prefix('think_');

        Cookie::set('name', 'thinkphp');
        var_dump(Cookie::get('name'));
        Cookie::delete('name');
        var_dump(Cookie::get('name'));

    }
}
