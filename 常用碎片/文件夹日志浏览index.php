<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(2);
define(ROOT,__DIR__);

if ($_GET['md5']) {
    show();
} else {
    index();
}
exit;

//json转化排版;
function take($filename) {
    echo '<pre>';
    $file = fopen($filename, "r");
    while (!feof($file)) {
        $line = trim(fgets($file));
        if ($line) {
            $line = trim($line);
            $tmp = json_decode($line);
            print_r($tmp);
            echo "\r\n";
        }
    }
    fclose($file);
}

/**
 * 列表
 */
function index() {
    $fname = ROOT . '/log/';
    $files = glob($fname . '*.txt');
    if ($files && is_array($files)) {
        foreach ($files as $value) {
            echo '<a href="' . $_SERVER['REQUEST_URI'] . '?&md5=' . md5($value) . '">' . basename($value) . '</a><br><br>';
        }
    }
}

/**
 * 详情;
 */
function show() {
    $md5 = trim($_GET['md5']);
    $fname = ROOT . '/log/';
    $files = glob($fname . '*.txt');
    if ($files && is_array($files)) {
        foreach ($files as $value) {
            if ($md5 != md5($value)) continue;
            take($value);
            // echo '<pre>' . basename($value) . '<hr>';
            // $data = file_get_contents($value);
            // echo $data;
        }
    }
}

