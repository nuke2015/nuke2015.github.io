<?php
namespace app\api\controller;

use app\common\base;

class Index
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {

        $d = base\CacheRedis::get('fs');
        if (!$d) {
            base\CacheRedis::set('fs', 'sfa' . time(), 3);
        }
        print_r($d);
        exit;

    }

}
