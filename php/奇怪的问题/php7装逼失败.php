<?php

$a = rand(0, 1);
// 多次运行,这个结果与预期[1,'yes']不符合
// $b = $a ?? 'yes';
$b = $a ? $a : 'yes';
echo $b;
