<?php
$header = array(
    'Accept-Language:zh-CN,zh;q=0.8',
    'Host:m.izhangchu.com',
    'User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.87 Safari/537.36',
    'Cookie:',
    'Upgrade-Insecure-Requests:',
);
// var_dump($header);
// exit;
echo myhttp::curl('http://m.izhangchu.com/', 'GET', array(), $header);

exit;

/**
测试
header("Content-type: text/html;charset=utf-8");
include 'myhttp.class.php';
echo "<pre>";
echo 'curl:<br>';
$data=myhttp::curl("http://www.baidu.com");
print_r($data);
echo 'multicurl:<br>';
$urls[] = 'http://www.baidu.com';
$urls[] = 'http://www.sina.com';
$urls[] = 'http://www.163.com';
print_r($urls);
$tmp= myhttp::multicurl($urls);
print_r($tmp);
 */
class myhttp
{
    const debug = 0;

    // 单线程
    public static function curl($url, $method = 'get', $params = array(), $header = array(), $opts = array())
    {

        // 报头合并
        if (count($header)) {
            $opts[CURLOPT_HTTPHEADER] = $header;
        }

        $ch = curl_init();

        // 参数构造
        self::build($opts, $url, $method, $params);
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (self::debug && $error) {
            throw new Exception('请求发生错误：' . $error);
        }

        return $data;
    }

    // 模拟多线程
    public static function multicurl($urls, $method = "get", $params = array(), $header = array(), $opts = array())
    {

        //参数构造
        $params = http_build_query($params);

        // 报头合并
        if (count($header)) {
            $opts[CURLOPT_HTTPHEADER] = $header;
        }

        $mh      = curl_multi_init();
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
    private static function build(&$opts, $url, $method, $params)
    {
        if ($params) {
            $vars = http_build_query($params);
        } else {
            $vars = '';
        }

        //补充参数
        $opts_base = array(CURLOPT_TIMEOUT => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36');
        foreach ($opts_base as $key => $value) {
            if (!isset($opts[$key])) {
                $opts[$key] = $value;
            }
        }

        if (strtolower($method) == 'post') {

            // POST请求
            $opts[CURLOPT_URL]  = $url;
            $opts[CURLOPT_POST] = 1;
            if ($vars) {
                $opts[CURLOPT_POSTFIELDS] = $vars;
            }
        } else {

            // GET请求
            if ($vars) {
                $url .= "?" . $vars;
            }

            $opts[CURLOPT_URL] = $url;
        }
        return $opts;
    }

    // 轻量协议头
    // http://sd
    // Array
    // (
    //     [0] => -1
    //     [1] => Resolving timed out after 1606 milliseconds
    // )

    public static function head($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $return = array(0, array());
        curl_exec($ch);
        if (curl_errno($ch)) {
            $return = array(-1, curl_error($ch));
        } else {
            $return = array(1, curl_getinfo($ch));
        }
        curl_close($ch);
        return $return;
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @return mixed
     */
    public static function client_ip($type = 0)
    {
        $type      = $type ? 1 : 0;
        static $ip = null;
        if ($ip !== null) {
            return $ip[$type];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }

            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    // 区域请求
    public static function postfield($url, $text = '', $header = array(), $opt = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $text);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // 定义协议头
        if ($header && count($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        // 增加扩展项
        if ($opt && count($opt)) {
            foreach ($opt as $key => $value) {
                curl_setopt($ch, $key, $value);
            }
        }
        $data = curl_exec($ch);
        return $data;
    }
}
