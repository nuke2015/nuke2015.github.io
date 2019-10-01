<?php
header("Content-type: image/gif");

$font = "./weathericons-regular-webfont.ttf"; //字体所放目录  


$size = 18; //字体大小
$font = "c:/windows/fonts/SIMHEI.TTF"; //字体类型，这里为黑体，具体请在windows/fonts文件夹中，找相应的font文件
$img = imagecreate(300, 100); //创建一个长为500高为16的空白图片
imagecolorallocate($img, 0xff, 0xff, 0xff); //设置图片背景颜色，这里背景颜色为#ffffff，也就是白色
$black = ImageColorAllocate($img, 0x00, 0x00, 0x00); //设置字体颜色，这里为#000000，也就是黑色
$red = ImageColorAllocate($img, 0xF7, 0x38, 0x09); //设置字体颜色，这里为#000000，也就是黑色
imagettftext($img, 24, 0, 5, 30, $red, $font, "￥280.15"); //将ttf文字写到图片中
imagettftext($img, $size, 0, 5, 60, $black, $font, "今天是你的生日,我的祖国,");
imagettftext($img, $size, 0, 5, 90, $black, $font, "祝您生日快乐!祖国母亲! "); 
header('Content-Type: image/png'); //发送头信息
imagepng($img);//输出图片，输出png使用imagepng方法，输出gif使用imagegif方法
