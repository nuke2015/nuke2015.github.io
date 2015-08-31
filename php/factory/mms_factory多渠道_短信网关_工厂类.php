<?php

// 配置文件,举个例子:
$config = array('first' => 'mms_zhangchu', 'MMS_JG_username' => '', 'MMS_JG_password' => '', 'MMS_ZC_userid' => '', 'MMS_ZC_account' => '', 'MMS_ZC_password' => '');

// 演示变量
$mobile = '13800138000';
$content = 'hello mms!';

// 发送短信集成方法
function send_mms($mobile, $content) {
    
    //默认使用哪种实现方式
    if ($config['first'] == 'mms_zhangchu') {
        
        //mysqli
        list($status, $info) = mms_zhangchu::send($mobile, $content);
        if (!$status) {
            list($status, $info) = mms_jiuage::send($mobile, $content);
        }
        return array($status, $info);
    } 
    else {
        
        //或mysql
        list($status, $info) = mms_jiuage::send($mobile, $content);
        if (!$status) {
            list($status, $info) = mms_zhangchu::send($mobile, $content);
        }
        return array($status, $info);
    }
}

//内部短信网关工厂类,
//作用:把不同渠道的具体实现,统一为相同的调用方式!
abstract class mms_factory
{
    protected static $debuginfo = array();
    
    //短信发送方法,抽象方法子类必须实现
    abstract public static function send($mobile, $content, $sendtime = '') {
    }
    
    //调试信息,子类继承即可,无须实现
    public static function debug() {
        return self::$debuginfo;
    }
}

//子类一
class class mms_jiuage extends mms_factory
{
    protected static $debuginfo = array();
    
    //发送短信,返回状态和提示
    public static function send($mobile, $content, $sendtime = '') {
        try {
            $resp = self::request();
            if ($resp['code'] == 0) {
                $return = array(1, $resp['message']);
            } 
            else {
                $return = array(0, $resp['message']);
            }
        }
        catch(Exception $e) {
            $return = array(-1, '');
        }
        
        //存入debuginfo
        self::$debuginfo = $resp;
        return $return;
    }
    
    //私有方法
    private static function request($mobile, $content, $sendTime = '') {
        $param = array();
        $param['username'] = C('MMS_JG_username');
        $param['password'] = C('MMS_JG_password');
        $param['mobile'] = $mobile;
        $param['content'] = $content . "【九阿哥】";
        $param['sendTime'] = $sendTime;
        $param['action'] = 'send';
        $param['extno'] = '';
        $return = array();
        try {
            $opt = array(CURLOPT_TIMEOUT => 3);
            $json = Http::curl(self::mms_host, 'post', $param, array(), $opt);
            if ($json) {
                
                // array('code'=>0,'message'=>'success','time'=>'2015-08-31 15:08:31','ip'=>'127.0.0.1');
                $return = (array)json_decode($xml, 1);
            }
        }
        catch(Exception $e) {
        }
        return $return;
    }
}

//子类二
class class mms_zhangchu extends mms_factory
{
    protected static $debuginfo = array();
    
    //发送短信,返回状态和提示
    public static function send($mobile, $content, $sendtime = '') {
        try {
            $resp = self::req();
            if ($resp['code'] == 200) {
                $return = array(1, $resp['body']);
            } 
            else {
                $return = array(0, $resp['body']);
            }
        }
        catch(Exception $e) {
            $return = array(-1, '');
        }
        
        //存入debuginfo
        self::$debuginfo = $resp;
        return $return;
    }
    
    //私有方法
    private static function req($mobile, $content, $sendTime = '') {
        $param = array();
        $param['userid'] = C('MMS_ZC_userid');
        $param['account'] = C('MMS_ZC_account');
        $param['password'] = C('MMS_ZC_password');
        $param['mobile'] = $mobile;
        $param['content'] = $content . "【掌厨】";
        $param['sendTime'] = $sendTime;
        $param['action'] = 'mms_send';
        $return = array();
        
        //$debuginfo喜欢存什么就存什么,以方便开发调试抓包为原则
        self::$debuginfo['param'] = $param;
        try {
            $opt = array(CURLOPT_TIMEOUT => 3);
            $xml = Http::curl(self::mms_host, 'get', $param, array(), $opt);
            if ($xml) {
                
                // array('code'=>200,'body'=>'Success','sendtime'=>'2015-08-31','channel'=>'shenzhen');
                $return = (array)simplexml_load_string($xml);
            }
        }
        catch(Exception $e) {
        }
        return $return;
    }
}
