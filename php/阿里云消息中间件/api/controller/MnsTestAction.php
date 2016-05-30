<?php
namespace app\api\controller;

use app\common\org\aliyun;

class MnsTestAction extends BaseAction
{

    // http://api.t.ddys168.com/?methodName=MnsTest
    public function index()
    {
        // 消息队列校验签名,并响应
        $xml=aliyun\mymns::xml_get();
        $this->log('mns',$xml);
        if($xml['Message']){
            $data=aliyun\mymns::base64_get($xml['Message']);
            $this->log('mns',$data);
        }
        return array(ERR_NONE, array('charge' => $ch));
    }
}
