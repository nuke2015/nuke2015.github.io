<?php
namespace app\api\controller;

use app\common\org\aliyun;

class AppHelloAction
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {
        $data = array('hello' => '你好', 'world' => '世界');
        
        // 消息投入队列
        $res  = aliyun\mymns::base64_send('CreateTopicAndPublishMessageExample', $data);
        var_dump($res);
        exit;

        return array(ERR_NONE, array('charge' => $ch));
    }
}
