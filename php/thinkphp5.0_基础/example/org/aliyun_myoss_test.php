<?php
namespace app\api\controller;

use app\common\org\aliyun;

class Index
{
    
    // http://127.0.0.183/?s=api/index/index
    public function index() {
        
        $aliyun_oss = aliyun\myoss::init();
        $file_local = 'robots.txt';
        $file_to_object = 'hello.txt';
        
        var_dump($aliyun_oss);
        $status = $aliyun_oss->upload_file_by_file('jinban-video', $file_to_object, $file_local);
        var_dump($status);
        $get_sign_url = $aliyun_oss->get_sign_url('jinban-video', $file_to_object);
        var_dump($get_sign_url);
        $meta = $aliyun_oss->get_object_meta('jinban-video', $file_to_object);
        var_dump($meta);
        exit;
    }
}
