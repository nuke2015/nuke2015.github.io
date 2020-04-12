<?php

$a=file('./image-list.txt');

$list=[];
if($a && count($a)){
    foreach ($a as $key => $value) {
        $value=trim($value);
        if($value){
            $list[]=$value;
        }
    }
}

foreach ($list as $key => $value) {
    echo "dk pull $value \r\n";
}

echo "\r\n";
echo "\r\n";
foreach ($list as $key => $value) {
    echo "dk save $value >".md5($value).".tar\r\n";
}

echo "\r\n";
echo "\r\n";
foreach ($list as $key => $value) {
    echo "dk load < ./".md5($value).".tar\r\n";
}

