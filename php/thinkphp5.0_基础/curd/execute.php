<?php
namespace app\weixin\controller;

class Index
{
    public function index() {
        echo '<pre>';
        
        $data = \think\Db::execute("UPDATE `ddys_ask_special` SET `count_view` = `count_view`+1 WHERE `id` = '8';");
        exit;
    }
}
