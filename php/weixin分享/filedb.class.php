<?php

// 文件缓存;
// 注意cache目录要有写权限
class filedb
{
    
    // cache::mem('hello',$data);
    // var_dump(cache::mem('hello'));
    public static function mem($key, $v = array()) {
        $file_name = self::key($key);
        if ($v) {
            $v = serialize($v);
            $v = "<?php\r\nreturn '{$v}';";
            return file_put_contents($file_name, $v);
        } else {
            if (file_exists($file_name)) {
                $v = include_once ($file_name);
                $v = unserialize($v);
            } else {
                $v = array();
            }
            return $v;
        }
    }
    
    // 删除
    public static function remove($key) {
        $file_name = self::key($key);
    }
    
    // 统一key
    private static function key($key) {
        return "cache/{$key}.php";
    }
}
