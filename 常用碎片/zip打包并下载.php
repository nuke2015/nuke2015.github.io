<?php
error_reporting(2047);

$path = 'D:\phpStudy\WWW\mqs';

//打包
$zip_name = 'abc.zip';
$zip = new \ZipArchive;
$res = $zip->open($zip_name, \ZipArchive::CREATE);

//处理打包含有相对路径的问题
$pathinfo=pathinfo($path);
chdir($pathinfo['dirname']);

//打包
Fzip::addFileToZip($pathinfo['basename'], $zip);

//下载
Fzip::download($zip_name,'hello.zip');

class Fzip {
    
    //下载
    public static function download($file_from, $file_to) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . $file_to);
        
        //文件名
        header("Content-Type: application/zip");
        
        //zip格式的
        header("Content-Transfer-Encoding: binary");
        
        //告诉浏览器，这是二进制文件
        header('Content-Length: ' . filesize($file_from));
        
        //告诉浏览器，文件大小
        @readfile($file_from);
    }
    
    // 打包
    public static function addFileToZip($path, $zip) {
        $handler = opendir($path);
        
        //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                
                //文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {
                    
                    // 如果读取的某个对象是文件夹，则递归
                    self::addFileToZip($path . "/" . $filename, $zip);
                } 
                else {
                    
                    //将文件加入zip对象
                    $zip->addFile($path . "/" . $filename);
                }
            }
        }
        @closedir($path);
    }
}
