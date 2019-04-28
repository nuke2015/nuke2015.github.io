<?php
namespace app\index\controller;

use think\Validate;

class Index
{
    public function index()
    {

        $validate = new Validate([
            'name'  => 'require|max:25',
            'email' => 'email',
        ]);
        $data = [
            'name'  => 'thinkphp',
            'email' => 'thinkphp@qq.com',
        ];
        if (!$validate->check($data)) {
            var_dump($validate->getError());
        }else{
            var_dump($validate);
        }

    }
}
