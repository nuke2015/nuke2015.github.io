<?php
namespace app\api\controller;

use app\api\model;

class Index
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {

        model\User::hello();
        exit;

    }

}
