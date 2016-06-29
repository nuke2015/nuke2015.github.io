<?php

// 请用测试key调试很快就通过了.

/**
 * Ping++ Server SDK
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写, 并非一定要使用该代码。
 * 该代码仅供学习和研究 Ping++ SDK 使用，只是提供一个参考。
 */

require dirname(__FILE__) . '/pingpp-php-master/init.php';

// api_key、app_id 请从 [Dashboard](https://dashboard.pingxx.com) 获取
$api_key = '';
$app_id  = '';

$channel = 'alipay_wap';
$amount  = '1';
$orderNo = substr(md5(time()), 0, 12);

// 设置请求签名密钥，密钥对需要你自己用 openssl 工具生成，把公钥填写到 https://dashboard.pingxx.com
\Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/private.pem');
// 也可以设置私钥内容
// \Pingpp\Pingpp::setPrivateKey(file_get_contents(__DIR__ . '/your_rsa_private_key.pem'));

/**
 * $extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array()。
 * 以下 channel 仅为部分示例，未列出的 channel 请查看文档 https://pingxx.com/document/api#api-c-new
 */
$extra = array();
switch ($channel) {
    case 'alipay_wap':
        $extra = array(
            'success_url' => 'http://example.com/success',
            'cancel_url'  => 'http://example.com/cancel',
        );
        break;
    case 'bfb_wap':
        $extra = array(
            'result_url' => 'http://example.com/result',
            'bfb_login'  => true,
        );
        break;
    case 'upacp_wap':
        $extra = array(
            'result_url' => 'http://example.com/result',
        );
        break;
    case 'wx_pub':
        $extra = array(
            'open_id' => 'openidxxxxxxxxxxxx',
        );
        break;
    case 'wx_pub_qr':
        $extra = array(
            'product_id' => 'Productid',
        );
        break;
    case 'yeepay_wap':
        $extra = array(
            'product_category' => '1',
            'identity_id'      => 'your identity_id',
            'identity_type'    => 1,
            'terminal_type'    => 1,
            'terminal_id'      => 'your terminal_id',
            'user_ua'          => 'your user_ua',
            'result_url'       => 'http://example.com/result',
        );
        break;
    case 'jdpay_wap':
        $extra = array(
            'success_url' => 'http://example.com/success',
            'fail_url'    => 'http://example.com/fail',
            'token'       => 'dsafadsfasdfadsjuyhfnhujkijunhaf',
        );
        break;
}

// 设置 API Key
\Pingpp\Pingpp::setApiKey($api_key);
try {
    $ch = \Pingpp\Charge::create(
        array(
            'subject'   => 'Your Subject',
            'body'      => 'Your Body',
            'amount'    => $amount,
            'order_no'  => $orderNo,
            'currency'  => 'cny',
            'extra'     => $extra,
            'channel'   => $channel,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'app'       => array('id' => $app_id),
        )
    );
    echo $ch;
} catch (\Pingpp\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
