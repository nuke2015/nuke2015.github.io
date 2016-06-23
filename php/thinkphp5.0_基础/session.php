<?php
namespace app\index\controller;

use think\Session;

class Index
{
    public function index()
    {

        Session::set('name', 'thinkphp');
        var_dump(Session::get('name'));

    }
}
