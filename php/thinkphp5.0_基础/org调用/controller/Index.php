<?php
namespace app\api\controller;

use app\api\org;

class Index
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {

        org\Test::hello();
        exit;

    }

}
