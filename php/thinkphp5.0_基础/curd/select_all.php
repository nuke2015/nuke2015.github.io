<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $data = \think\Db::table('user')->where(1)->select();
        print_r($data);
        exit;
    }
}
