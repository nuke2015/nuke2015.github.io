<?php
namespace app\hello\controller;

class Index
{
    public function index()
    {

        echo 'hello/index/index';

        
    }

    // http://127.0.0.183/?s=Index/index/hello
    public function hello(){
        echo 'hello/index/hello';
        exit;
    }
}
