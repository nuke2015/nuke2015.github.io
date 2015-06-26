<?php

/**
 测试
 header("Content-type: text/html;charset=utf-8");
 include 'http.class.php';
 echo "<pre>";
 echo 'curl:<br>';
 $data=http::curl("http://www.baidu.com");
 print_r($data);
 echo 'multicurl:<br>';
 $urls[] = 'http://www.baidu.com';
 $urls[] = 'http://www.sina.com';
 $urls[] = 'http://www.163.com';
 print_r($urls);
 $tmp= Http::multicurl($urls);
 print_r($tmp);
 */

class http
{
    const debug = 0;
    
    // 单线程
    public static function curl($url, $method = 'get', $params = array(), $header = array()) {
        
        $opts = array(CURLOPT_TIMEOUT => 30, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36');
        
        // 报头合并
        if ($header) $opts[CURLOPT_HTTPHEADER] = $header;
        
        $ch = curl_init();
        
        // 参数构造
        self::build($opts, $url, $method, $params);
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (self::debug && $error) throw new Exception('请求发生错误：' . $error);
        return $data;
    }
    
    // 模拟多线程
    public static function multicurl($urls, $method = "get", $params = array(), $headers = array()) {
        
        //参数构造
        $params = http_build_query($params);
        
        $opts = array(CURLOPT_TIMEOUT => 30, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');
        
        // 报头合并
        if ($header) $opts[CURLOPT_HTTPHEADER] = $header;
        
        $mh = curl_multi_init();
        $chArray = array();
        foreach ($urls as $url) {
            
            // 参数构造
            self::build($opts, $url, $method, $params);
            $ch = curl_init();
            curl_setopt_array($ch, $opts);
            curl_multi_add_handle($mh, $ch);
            $chArray[] = $ch;
        }
        
        // 归零
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);
        
        $return = array();
        foreach ($chArray as $ch) {
            $return[] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
        }
        $error = curl_error($ch);
        if (self::debug && $error) {
            throw new Exception('请求发生错误：' . $error);
        }
        curl_multi_close($mh);
        return $return;
    }
    
    // 方法构造
    private static function build(&$opts, $url, $method, $params) {
        $vars='';
        if ($params) $vars = http_build_query($params);
        if (strtolower($method) == 'post') {
            
            // POST请求
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            if ($vars) {
                $opts[CURLOPT_POSTFIELDS] = $vars;
            }
        } else {
            
            // GET请求
            if ($vars) $url.= "?" . $vars;
            $opts[CURLOPT_URL] = $url;
        }
        return $opts;
    }
}
