<?php
// 数组分批
$update = range(1, 100);
$count  = count($update);
$size   = 10;
// 批量更新
if ($update && count($update)) {
    for ($i = 0; $i < $count; $i += $size) {
        $item = array_slice($update, $i, $size);
        print_r($item);
    }
    print_r($update);
}


