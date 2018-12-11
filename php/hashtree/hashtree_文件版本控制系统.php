<?php

$result = [];
dire_recursion('F:\zhihukeji\dev\php\cube\public\weixin', function ($file) use (&$result) {
    $hash               = md5_file($file);
    $result[md5($file)] = [$file, $hash];
});
var_dump($result);

function dire_recursion($dir, $func)
{
    if (!is_dir($dir)) {
        return false;
    }
    //打开目录
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        //排除掉当前目录和上一个目录
        if ($file == "." || $file == "..") {
            continue;
        }
        $file = $dir . DIRECTORY_SEPARATOR . $file;
        //如果是文件就打印出来，否则递归调用
        if (is_file($file)) {
            $func($file);
        } elseif (is_dir($file)) {
            dire_recursion($file, $func);
        }
    }
}
