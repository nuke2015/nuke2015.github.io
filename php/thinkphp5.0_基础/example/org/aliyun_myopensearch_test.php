<?php
namespace app\api\controller;

use app\common\org\aliyun;

class Index
{
    
    // http://127.0.0.183/?s=api/index/index
    public function index() {
        
        $client = aliyun\myopensearch::client();
        var_dump($client);
        $search_query =aliyun\myopensearch::search_query('kitchen','白菜');
        // var_dump($search_query);
        $suggest_query=aliyun\myopensearch::suggest_query('kitchen','dishes_name','萝卜');
        var_dump($suggest_query);
        exit;
    }
}
