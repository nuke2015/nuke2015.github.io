<?php

$file = '{"name":"x.png","type":"application\/octet-stream","tmp_name":"C:\\Users\\Administrator\\AppData\\Local\\Temp\\php15CB.tmp","error":0,"size":35866}';
$tmp  = json_decode($file, 1);
// 这里是null,但是json结构在bejson.com能正常校验
var_dump($tmp);
