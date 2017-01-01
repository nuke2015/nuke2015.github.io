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
myhttp::curl('http://m.izhangchu.com/', 'GET', array(), $header);

exit;

// 响应体
function curl_write_function($ch, $content)
{
    echo $content;
    return strlen($content);
}

// 响应头
function curl_header_function($ch, $header)
{
    header($header);
    return strlen($header);
}

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
        // 获响应结：
        $data = curl_exec($ch);

        $error = curl_error($ch);
        curl_close($ch);
        if (self::debug && $error) {
            throw new Exception('请求发生错误：' . $error);
        }

        return $data;
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
        $opts[CURLOPT_HEADER]         = 0;
        $opts[CURLOPT_HEADERFUNCTION] = 'curl_header_function';
        $opts[CURLOPT_WRITEFUNCTION]  = 'curl_write_function';
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

}
