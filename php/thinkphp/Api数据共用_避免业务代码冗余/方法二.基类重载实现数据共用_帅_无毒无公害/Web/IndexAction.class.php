<?php

/**
 * Thinkphp通过重载基类的方法,
 * 实现跨分组数据拦截,
 * 进而达到api数据与其它业务共用的目地.
 * 
 * 锋子
 * 2015年8月19日 04:53:12
 * 
 * 本次操作,发现一个奇妙的问题,
 * 就是Api/TestWelcome代码里是继承BaseAction的,
 * 但是H5/IndexAction也是继承BaseAction的.
 * 而在调用的时候TestWelcome的BaseAction被H5项目的BaseAction重载了.
 * 所以,也可以通过重载BaseAction中的公共输出方法,
 * 来实现Api数据共用!
 * 
 */
class IndexAction extends BaseAction
{
    public function index() {
        
        // 原TestWelcome控制器走的是api项目的公共输出
        // 只要把api的公共输出result,重载一下就实现数据共用了.
        // 这样可以在所有的分组中使用相同的数据.
        // 比如,公从号Weixin,手机站Mobile,H5小页面H5,App内嵌页App,PC站Www,等
        $Test = A('Api/TestWelcome');
        
        // 触发方法
        $Test->index();
        
        // 取数据;
        $data_api = $Test->data_api;

        dump($data_api);
    }
}
