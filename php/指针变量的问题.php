<?php
// 指针变量二次遍历被修改
echo '<pre>';
$a = range(1, 3);
foreach ($a as & $v) {
    echo $v . ",";
}
print_r($a);
echo '<hr/>';
foreach ($a as $v) {
    echo $v . ",";
}
print_r($a);

// // 输出
// 1,2,3,Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
// )
// 1,2,2,Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 2
// )
