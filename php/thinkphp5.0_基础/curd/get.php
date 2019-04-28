<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        // 取一条,对象
        $user = \think\Loader::model('User');
        $info = $user->get(1);
        print_r($info);
        exit;
    }
}
