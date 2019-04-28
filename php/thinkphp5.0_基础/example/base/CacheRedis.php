<?php
namespace app\api\controller;

use app\common\base;

class Index
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {
        base\CacheRedis::set('fs', 'sfa');
        print_r(base\CacheRedis::get('fs'));
        base\CacheRedis::remove('fs1');
        print_r(base\CacheRedis::get('fs'));
        exit;

    }

}
