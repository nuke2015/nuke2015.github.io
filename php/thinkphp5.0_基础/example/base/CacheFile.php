<?php
namespace app\api\controller;

use app\common\base;

class Index
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {
        base\CacheFile::set('fs', 'sfa');
        print_r(base\CacheFile::get('fs'));
        base\CacheFile::remove('fs1');
        print_r(base\CacheFile::get('fs'));
        // base\CacheFile::clear();
        exit;

    }

}
