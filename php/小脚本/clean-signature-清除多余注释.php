<?php
$di      = new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS);
$it      = new RecursiveIteratorIterator($di);
$fileArr = [];
foreach ($it as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) == "php") {
        ob_start();
        echo $file;
        $file      = ob_get_clean();
        $fileArr[] = $file;
    }
}
// todo;
var_dump($fileArr);
// $arr   = [T_COMMENT, T_DOC_COMMENT];
$arr   = [T_DOC_COMMENT];
$count = count($fileArr);
if ($count) {
    for ($i = 1; $i < $count; $i++) {
        $fileStr = file_get_contents($fileArr[$i]);
        foreach (token_get_all($fileStr) as $token) {
            if (in_array($token[0], $arr)) {
                $fileStr = str_replace($token[1], '', $fileStr);
            }
        }
        file_put_contents($fileArr[$i], $fileStr);
    }
} else {
    echo 'well done!';
}
