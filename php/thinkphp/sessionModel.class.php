<?php

// 用户会话分布存储
class sessionModel extends redisModel {
    
    //设置
    public static function get($key) {
        $key = self::key($key);
        return parent::get($key);
    }
    
    //设置
    public static function set($key, $value, $time = 7200) {
        $key = self::key($key);
        return parent::set($key, $value, $time);
    }
    
    //删除
    public static function remove($key) {
        $key = self::key($key);
        return parent::remove($key);
    }
    
    //键名修饰
    private static function key($key) {
        $sess_id = session_id();
        $key = "sessionModel#{$sess_id}#{$key}";
        return $key;
    }
}
