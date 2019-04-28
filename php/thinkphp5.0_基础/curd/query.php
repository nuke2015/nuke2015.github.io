<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $data = \think\Db::query("select * from user where user_id>? and user_id<?",[2,8]);
        print_r($data);
        exit;
    }
}
