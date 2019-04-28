<?PHP

header("Content-Type: text/html; charset=UTF-8");

$body = '';
//要post的数据
$argv = array(
    'sn'      => 'mysn', ////替换成您自己的序列号
    'pwd'     => strtoupper(md5('mysn' . 'mypwd')), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
    'mobile'  => '135xxxxxxsx', //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
    'content' => '您好测试,短信测试[App]', //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
    'ext'     => '',
    'stime'   => '', //定时时间 格式为2011-6-29 11:09:21
    'msgfmt'  => '',
    'rrid'    => '',
);

//构造要post的字符串
$body   = http_build_query($argv);
$length = strlen($body);
// print_r($body);exit;

//创建socket连接,超时10秒
$fp = fsockopen("sdk.entinfo.cn", 8061, $errno, $errstr, 10) or exit($errstr . "--->" . $errno);

//构造post请求的头
$header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
$header .= "Host:sdk.entinfo.cn\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . $length . "\r\n";
$header .= "Connection: Close\r\n\r\n";
//添加post的字符串
$header .= $body . "\r\n";
//发送post的数据
// echo $header;exit;

fputs($fp, $header);
$inheader = 1;
while (!feof($fp)) {
    $line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据
    if ($inheader && ($line == "\n" || $line == "\r\n")) {
        $inheader = 0;
    }
    if ($inheader == 0) {
        // echo $line;
    }
}

print_r($line);
exit;

// POST /webservice.asmx/mdsmssend HTTP/1.1
// Host:sdk.entinfo.cn
// Content-Type: application/x-www-form-urlencoded
// Content-Length: 224
// Connection: Close

// sn=mysn&pwd=DBDFE17D3778ECCB7086AB289BD96178&mobile=135xxxxxxsx&content=%E6%82%A8%E5%A5%BD%E6%B5%8B%E8%AF%95%2C%E7%9F%AD%E4%BF%A1%E6%B5%8B%E8%AF%95%5B%E6%8E%8C%E5%B0%8F%E5%8E%A8%E7%9C%9F%E6%A3%92%5D&ext=&stime=&msgfmt=&rrid=


