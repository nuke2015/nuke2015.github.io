<?php
namespace app\common\service;

use app\common\org;

class BaiduPush
{
    const TOKEN_BAIDU = '';

    // 推送
    public static function urls($host, $urls)
    {
        $api = 'http://data.zz.baidu.com/urls?site=' . $host;
        return self::send($api, $urls);
    }

    // 更新
    public static function update($host, $urls)
    {
        $api = 'http://data.zz.baidu.com/update?site=' . $host;
        return self::send($api, $urls);
    }

    // 删除
    public static function del($host, $urls)
    {
        $api = 'http://data.zz.baidu.com/del?site=' . $host;
        return self::send($api, $urls);
    }

    // 发报
    private static function send($api, $urls)
    {
        $txt    = implode("\n", $urls);
        $header = array('Content-Type: text/plain');
        $api .= '&token=' . self::TOKEN_BAIDU;
        $jsonstr = org\myhttp::postfield($api, $txt, $header);
        return json_decode($jsonstr, 1);
    }

}
