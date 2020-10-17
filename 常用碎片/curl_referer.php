<?php


$openurl='http://www.soso.com';
$ch = curl_init($openurl);
$user_agent = "Baiduspider+(+http://www.baidu.com/search/spider.htm)";
curl_setopt($ch, CURLOPT_URL, $openurl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://wenwen.soso.com');//
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
$file = curl_exec($ch);
curl_close($ch);