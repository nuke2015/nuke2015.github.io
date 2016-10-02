<?php

// 回环取
function array_circle($arr, $pos, $len)
{
    $total = count($arr);
    if ($pos + $len >= $len && $pos + $len < $total) {
        $result = array_slice($arr, $pos, $len);
    } elseif ($pos + $len >= $len && $pos + $len >= $total) {
        $result_a = array_slice($arr, $pos, $len);
        $pos + $len - $total;
        $result_b = array_slice($arr, 0, $pos + $len - $total);
        $result   = array_merge($result_a, $result_b);
    } elseif ($pos + $len < $len) {
        $result_a = array_slice($arr, $pos, $len);
        $result_b = array_slice($arr, 0, $pos + $len);
        $result   = array_merge($result_a, $result_b);
    }
    return $result;
}

$a = range(1, 10);
print_r($a);
print_r(array_circle($a, 2, 4));
print_r(array_circle($a, 8, 4));
print_r(array_circle($a, 10, 4));
print_r(array_circle($a, -2, 4));

// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
//     [4] => 5
//     [5] => 6
//     [6] => 7
//     [7] => 8
//     [8] => 9
//     [9] => 10
// )
// Array
// (
//     [0] => 3
//     [1] => 4
//     [2] => 5
//     [3] => 6
// )
// Array
// (
//     [0] => 9
//     [1] => 10
//     [2] => 1
//     [3] => 2
// )
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
// )
// Array
// (
//     [0] => 9
//     [1] => 10
//     [2] => 1
//     [3] => 2
// )


// 扩展：
// 对于大型的数据回环读取，可以采用把数据存仓库，
// 然后把数据的键名组成环，然后切片得到键名数组，
// 然后根据键名去仓库提取目标数据的转折办法。

