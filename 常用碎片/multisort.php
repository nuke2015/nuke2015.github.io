<?php

// 二维排序
public static function multisorter($data, $field) {
    $sorter = array();
    if ($data && count($data)) {
        foreach ($data as $key => $value) {
            $sorter[] = $value[$field];
        }
        array_multisort($sorter, SORT_ASC, $data);
    }
    return $data;
}
