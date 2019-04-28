<?php

/**
 *数组相关功能
 */
class Farray {
    
    // 二维排序
    public static function multisort($data, $field, $order = SORT_ASC) {
        $sorter = array();
        if ($data && count($data)) {
            foreach ($data as $key => $value) {
                $sorter[] = intval($value[$field]);
            }
            array_multisort($sorter, $order, $data);
        }
        return $data;
    }
}
