<?php
class JSSDK
{
    private $appId;
    private $appSecret;
    
    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    
    public function logme($data) {
        $result = date("Y-m-d H:i:s", time()) . "\r\n";
        $result.= print_r($data, 1) . "\r\n";
        file_put_contents('weixin.log', $result, FILE_APPEND);
    }
    
    public function getSignPackage() {
        $this->logme('getSignPackage');
       $jsapiTicket = $this->getJsApiTicket();
        // $jsapiTicket = 'sM4AOVdWfPE4DxkXGEs8VNaPvR4gc04S3yUnbCAI3U4m93p8tdhJa5VEHhvVN82E13ruN45iDUexjN4nz-4TNQ';
        $this->logme($jsapiTicket);
        
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $this->logme($url);
        $nonceStr = $this->createNonceStr();
        $this->logme($nonceStr);
        
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $this->logme($string);
        
        $signature = sha1($string);
        $this->logme($signature);
        
        $signPackage = array("appId" => $this->appId, "nonceStr" => $nonceStr, "timestamp" => $timestamp, "url" => $url, "signature" => $signature, "rawString" => $string);
        $this->logme($signPackage);
        
        return $signPackage;
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str.= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    private function getJsApiTicket() {
        
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        // $data = json_decode(file_get_contents("jsapi_ticket.json"));
        
        // if ($data && $data->expire_time < time()) {
        if (1) {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $this->logme("ticket_url:" . $url);
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
        $this->logme("ticket:" . $ticket);
        return $ticket;
    }
    
    private function getAccessToken() {
        
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        // $data = json_decode(file_get_contents("access_token.json"));
        
        // if ($data && $data->expire_time < time()) {
        if (1) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $this->logme("token_url:" . $url);
            $res = json_decode($this->httpGet($url));
            $this->logme($res);
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        $this->logme("access_token:" . $access_token);
        return $access_token;
    }
    
  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
	// $error = curl_error($ch);
	// $this->logme($error);
    curl_close($curl);
    return $res;
  }
}
