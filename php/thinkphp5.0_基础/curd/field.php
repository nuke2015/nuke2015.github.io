<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $data = \think\Db::table('user')->where(1)->field('user_id,phone,email')->limit(0,2)->select();
        print_r($data);
        exit;
    }
}
