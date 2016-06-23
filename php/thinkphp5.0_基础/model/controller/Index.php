<?php
namespace app\index\controller;

class Index
{
    public function index()
    {

        // 实例化模型
        $user = \think\Loader::model('User');
        // $info = $user->get(612022);
        // var_dump($info->nick);

        // // 根据主键获取多个对象
        $list = $user::all('1,2,3');
        var_dump($list);

        // 获取某个用户的积分
        $nick = $user::where('user_id', 612022)->value('nick');
        var_dump($nick);
        
    }
}
