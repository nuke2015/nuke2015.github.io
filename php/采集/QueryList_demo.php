<?php

//采集某页面html内容
$data = QueryList::Query('http://cms.querylist.cc/bizhi/453.html', array(
    'html' => array(),
));
//打印结果
print_r($data);
exit;

//采集某页面所有的图片
$data = QueryList::Query('http://cms.querylist.cc/bizhi/453.html', array(
    'images' => array('img', 'src'),
));
//打印结果
print_r($data);
exit;

//使用插件,定制协议头,定制采集结果
$urls = QueryList::run('Request', array(
    'target'     => 'http://cms.querylist.cc/news/list_2.html',
    'referrer'   => 'http://cms.querylist.cc',
    'method'     => 'GET',
    'params'     => ['var1' => 'testvalue', 'var2' => 'somevalue'],
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
    'cookiePath' => './cookie.txt',
    'timeout'    => '30',
))->setQuery(['link' => array('h2>a', 'href'), 'html' => array('*', 'html')])->getData();
print_r($urls);
exit;

// 使用全局变量,单条结果回调,总结果回调
$i = 0;

//使用插件
$urls = QueryList::run('Request', array(
    'target'     => 'http://cms.querylist.cc/news/list_2.html',
    'referrer'   => 'http://cms.querylist.cc',
    'method'     => 'GET',
    'params'     => ['var1' => 'testvalue', 'var2' => 'somevalue'],
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
    'cookiePath' => './cookie.txt',
    'timeout'    => '30',
))->setQuery(['link' => array('h2>a', 'href'), 'html' => array('h2>a', 'text', '', function ($txt) {
    return 'hello' . $txt;
})])->getData(function ($item) {
    global $i;
    $item['index'] = $i++;
    return $item;
});
print_r($urls);
exit;
