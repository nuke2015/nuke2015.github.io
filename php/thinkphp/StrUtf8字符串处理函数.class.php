<?php
class StrUtf8 {
    
    /**
     * 可以统计中文字符串长度的函数
     * @param $str 要计算长度的字符串
     * @param $type 计算长度类型，0(默认)表示一个中文算一个字符，1表示一个中文算两个字符
     *
     */
    public static function abslength($str) {
        if (empty($str)) {
            return 0;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'utf-8');
        } 
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }
    
    /*
    utf-8编码下截取中文字符串,参数可以参照substr函数
    @param $str 要进行截取的字符串
    @param $start 要进行截取的开始位置，负数为反向截取
    @param $end 要进行截取的长度
    */
    public static function utf8_substr($str, $start = 0) {
        if (empty($str)) {
            return false;
        }
        if (function_exists('mb_substr')) {
            if (func_num_args() >= 3) {
                $end = func_get_arg(2);
                return mb_substr($str, $start, $end, 'utf-8');
            } 
            else {
                mb_internal_encoding("UTF-8");
                return mb_substr($str, $start);
            }
        } 
        else {
            $null = "";
            preg_match_all("/./u", $str, $ar);
            if (func_num_args() >= 3) {
                $end = func_get_arg(2);
                return join($null, array_slice($ar[0], $start, $end));
            } 
            else {
                return join($null, array_slice($ar[0], $start));
            }
        }
    }
}
