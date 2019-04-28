<?php
namespace app\weixin\controller;

use app\common\org\weixin;

class RespTextAction extends BaseAction
{
    // http://127.0.0.183/?s=api/index/index
    public function index()
    {
        $WeixinMp = new weixin\WeixinMp();
        $mp       = $WeixinMp->request();
        $WeixinMp->response('暴走大件事啦~!'."\r\n".'<a href="http://baidu.com" >fengfeng</a>'."\r\n"."\r\n".'空白两行'."\r\n"."继续哔哔哩哩!");
        exit;
    }
}
