<?php

$x = range(0, 9);
var_dump($x);

// 处理并回收结果
var_dump('array_map');
$b = array_map(function ($item) {
    echo $item;
    $item = 'x' . $item;
    return $item;
}, $x);
var_dump($b, $x);

//  都处理一遍,但不回收结果
var_dump('array_walk');
$c = array_walk($x, function ($item) {
    echo $item;
    return 'c' . $item;
});
var_dump($c, $x);

var_dump('array_column');
$x      = [['id' => 1, 'title' => 'title1'], ['id' => 3, 'title' => 'title2'], ['id' => 3, 'title' => 'title3']];
$titles = array_column($x, 'title');
var_dump($x, $titles);
