<?php

// 测试用例
// $utf8=utf8::is_utf8($str);
// if(!$utf8){
//     $str=utf8::auto_charset($str,'utf-8','gbk');
// }
// var_dump($str);



/**
 * 字符编码相关
 */
class utf8
{
    
    /**
     +----------------------------------------------------------
     * 检查字符串是否是UTF8编码
     +----------------------------------------------------------
     * @param string $string 字符串
     +----------------------------------------------------------
     * @return Boolean
     +----------------------------------------------------------
     */
    static public function is_utf8($string) {
        return preg_match('%^(?:
             [\x09\x0A\x0D\x20-\x7E]            # ASCII
           | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
           |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
           | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
           |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
           |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
           | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
           |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
       )*$%xs', $string);
    }
    
    // 自动转换字符集 支持数组转换
    public static function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
            
            //如果编码相同或者非字符串标量则不转换
            return $fContents;
        }
        if (is_string($fContents)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($fContents, $to, $from);
            } 
            elseif (function_exists('iconv')) {
                return iconv($from, $to, $fContents);
            } 
            else {
                return $fContents;
            }
        } 
        elseif (is_array($fContents)) {
            foreach ($fContents as $key => $val) {
                $_key = self::auto_charset($key, $from, $to);
                $fContents[$_key] = self::auto_charset($val, $from, $to);
                if ($key != $_key) unset($fContents[$key]);
            }
            return $fContents;
        } 
        else {
            return $fContents;
        }
    }
}
