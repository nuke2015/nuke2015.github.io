<?php

//修改超时设置为60秒;
define('CURLOPT_TIMEOUT_CLIENT', 60);
include_once (__DIR__ . '/http.class.php');

/**
 * 大众点评,主动调用;
 */
class dianping {
    
    //点评接口地址;
    const URL_DIANPING = 'http://m.api.51ping.com/tohome/openapi/xxxx/';
    
    //点评密钥;
    const APPKEY = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
    
    private static $retry = 0;
    
    /**
     * 服务方接单后，更新状态进度。服务方更新状态目前只支持13（确认订单）、3（技师出发）、4（服务中）、5（服务已完成）四种状态。
     * @return [type] [description]
     */
    public static function updateOrderStatus($orderId, $status) {
        $param = array();
        $param['methodName'] = 'updateOrderStatus';
        $param['orderId'] = strval($orderId);
        $param['status'] = intval($status);
        $sign = self::sign($param);
        $param['sign'] = $sign;
        $data = self::send(self::URL_DIANPING, 'post', $param);
        if ($data) {
            return json_decode($data, 1);
        } else {
            return array();
        }
    }
    
    /**
     * 服务方调用点评，取消订单并退款，不管当前订单状态（如果用户已支付）。目前默认全额退款，后续会支持服务方设置价格。安全考虑，除了签名验证，点评端会做ip白名单。订单状态=14.
     * @return [type] [description]
     */
    public static function partnerCancelOrder($orderId) {
        $param = array();
        $param['methodName'] = 'partnerCancelOrder';
        $param['orderId'] = strval($orderId);
        $sign = self::sign($param);
        $param['sign'] = $sign;
        $data = self::send(self::URL_DIANPING, 'post', $param);
        if ($data) {
            return json_decode($data, 1);
        } else {
            return array();
        }
    }
    
    /**
     * 服务方调用点评，更新订单信息。目前只支持更新服务的指派技师（确认后即可调用），后续视需要可开通更多信息更新。技师id用于做评价及再次预约入口。
     */
    public static function updateOrderInfo($orderId, $technicianId) {
        $param = array();
        $param['methodName'] = 'updateOrderInfo';
        $param['orderId'] = strval($orderId);
        $param['technicianId'] = strval($technicianId);
        $sign = self::sign($param);
        $param['sign'] = $sign;
        $data = self::send(self::URL_DIANPING, 'post', $param);
        if ($data) {
            return json_decode($data, 1);
        } else {
            return array();
        }
    }
    
    /**
     * 统一请求发送接口,便于做日志,做失败重试!
     * @param  [type] $url    [description]
     * @param  [type] $method [description]
     * @param  [type] $param  [description]
     * @return [string]         [网络通信原始返回值]
     */
    private static function send($url, $method, $param) {
        
        //重试计数器
        self::$retry+= 1;
        $data = http::curl(self::URL_DIANPING, 'post', $param);
        if ($data) {
            return $data;
        } else {
            
            //超时或网络错误.请求失败才重试一次
            if (self::$retry == 1) {
                return self::send($url, $method, $param);
            } else {
                return '';
            }
        }
    }
    
    /**
     * 因为调用点评接口时,要签名;
     * 所以把签名算法独立出来.
     *  测试:
     $param=array('methodName'=>'queryAvailableTechnicians','version'=>'1.0','partnerId'=>'dianping','productId'=>4321,'serviceAddress'=>'北京市朝阳区');
     $token='E15D48CE15536CA94C7E55D5E8963D99';
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public static function sign($param) {
        ksort($param);
        $combined_str = '';
        if (count($param)) {
            foreach ($param as $k => $v) {
                $combined_str.= $k . $v;
            }
        }
        $combined_str.= self::APPKEY;
        $token = strtoupper(md5($combined_str));
        return $token;
    }
}
