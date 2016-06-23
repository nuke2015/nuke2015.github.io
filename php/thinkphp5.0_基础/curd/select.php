<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $where = array();
        $where['user_id'] = 1;
        $data = \think\Db::table('user')->where($where)->select();
        print_r($data);
        exit;
    }
}
