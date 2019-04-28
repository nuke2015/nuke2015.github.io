<?php
namespace app\index\controller;

use think\Validate;

class Index
{
    public function index()
    {

        $rule = [
            'name'  => 'require|max:25',
            'age'   => 'number|between:1,120',
            'email' => 'email',
        ];
        $msg = [
            'name.require' => '名称必须',
            'name.max'     => '名称最多不能超过25个字符',
            'age.number'   => '年龄必须是数字',
            'age.between'  => '年龄只能在1-120之间',
            'email'        => '邮箱格式错误',
        ];
        $data = [
            'name'  => 'thinkphp',
            'age'   => 10,
            'email' => 'thinkphp@qq.com',
        ];
        $validate = new Validate($rule, $msg);
        $result   = $validate->check($data);
        var_dump($result);
        var_dump($validate);

    }
}
