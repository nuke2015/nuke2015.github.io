<?php
namespace app\api\controller;

use app\common\org;

class Index
{
    
    // http://127.0.0.183/?s=api/index/index
    public function index() {
        
        echo '<pre>';
        echo 'curl one!';
        $data = org\myhttp::curl("http://news.163.com");
        print_r($data);
        echo 'multicurl:<br>';
        $urls[] = 'http://www.qq.com';
        $urls[] = 'http://www.sina.com';
        $urls[] = 'http://www.163.com';
        print_r($urls);
        $tmp = org\myhttp::multicurl($urls);
        print_r($tmp);
    }
}
