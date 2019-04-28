<?php
namespace app\api\controller;

use app\common\model;

class AppHelloAction
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {

        $ddys_user_map = new model\ddys_user_map();
        $where         = "1";
        // 条数
        $data          = $ddys_user_map->count($where);
        var_dump($data);
        
        // 分页
        $data=$ddys_user_map->page($where,2,2);
        print_r($data);

        // 批量
        $data=$ddys_user_map->page($where,'*','0,5','id','DESC');
        print_r($data);

        exit;
        return array(ERR_NONE, 'AppHelloAction');
    }
}
