<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $where = 1;
        $total = \think\Db::name('user')->where($where)->count();
        $data = \think\Db::name('user')->where($where)->page(1, 2)->select();
        var_dump($total);
        print_r($data);
        exit;
    }
}
