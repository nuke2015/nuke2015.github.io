<?php
$url = "https://www.baidu.com";
// $url =  "https://123.125.114.144";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// 增加请求头文件
// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Host:jy.58.com'));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //这个是重点。
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
// var_dump($curl);exit;
$data = curl_exec($curl);
// 打印获取curl请求信息
// $curl_info = curl_getinfo( $curl );
// print_r($curl_info);
// 打印错误信息
// curl_error( $curl);
curl_close($curl);
var_dump($data);
