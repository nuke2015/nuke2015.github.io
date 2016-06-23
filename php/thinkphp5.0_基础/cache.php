<?php
namespace app\index\controller;
use think\Cache;

class Index
{
    public function index()
    {

        // Cache::connect($options);

        Cache::set('hellof','fs'.time(),10);
        print_r(Cache::get('hellof'));
        Cache::rm('hellof');
        Cache::clear();
        print_r(Cache::get('hellof'));
    }
}
