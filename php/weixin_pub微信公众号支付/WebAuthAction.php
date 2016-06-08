<?php
namespace app\weixin\controller;

use app\common\org;
use think\Config;

require_once APP_PATH . '/common/composer/vendor/autoload.php';

// 三步握手取openid
class WebAuthAction extends BaseAction
{
    public function index()
    {
        $this->show('o0GJpsxxxBCjocQmpDMYbhR0');
        exit;

        $url = 'http://weixin.t.ddys168.com/?methodName=Auth';
        if ($_GET['code']) {
            $open_id = org\pingxx::getopenid($_GET['code']);
            $this->open_id;
            $this->show($open_id);
        } else {
            org\pingxx::headerurl($url);
            exit;
        }

    }

    private function show($open_id)
    {
        $config            = array();
        $config['open_id'] = $open_id;
        $config['app_id']  = Config::get('pingxx.app_id');
        $View              = new \think\View();
        $View->assign('config', $config);
        echo $View->fetch('index/WebAuth');
        exit;
    }

}
