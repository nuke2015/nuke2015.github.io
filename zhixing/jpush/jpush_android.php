<?php

/**
 * 极光推送Android客户端
 * 测试用例
 $jpush_android=new jpush_android();
 // $jpush_android->setDebug(1);
 list($stat,$data)=$jpush_android->order_new_notice('','hello',array('order_id'=>1));
 print_r($stat);
 print_r($data);
 exit;
 */

//引入极光SDK;
require_once __DIR__ . '/jpush.php';
use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

class jpush_android extends jpush
{
    
    /**
     * 新订单通知
     * @param  [type] $regid [description]
     * @param  [type] $title [description]
     * @param  [type] $data  [description]
     * @return [array]        [状态+数据]
     */
    public function order_new_notice($regid, $title, $data) {
        $pusher = $this->init()->push();
        $setPlatform = M\platform('android');
        
        //广播/组播/单播
        $setAudience = M\audience(M\registration_id(array($regid)));
        
        // 小心,此处是广播
        // $setAudience = M\all;
        
        //扩展选项;
        $option = M\android($title, $title, 1, $data);
        
        //通知数据;
        $setNotification = M\notification($title, $option);
        $pusher->setPlatform($setPlatform)->setAudience($setAudience)->setNotification($setNotification);
        try {
            
            //是否回显数据结构;
            if ($this->debug) {
                $json = $pusher->printJSON()->send();
                return array(1, $json);
            } else {
                $json = $pusher->send();
                return array(1, $json);
            }
        }
        catch(Exception $e) {
            
            //返回出错信息;
            return array(0, $e);
        }
    }
}
