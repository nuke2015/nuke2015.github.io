<?php

/**
 * 分布式事务锁
 */

// 测试用例
// import("@.service.LockService");
// $do=LockService::lock('user1',600);
// var_dump($do);
// echo "\r\n";
// $info=LockService::check('user1');
// var_dump($info);
// echo "\r\n";
// $do=LockService::unlock('user1');
// var_dump($do);
// echo "\r\n";
// $info=LockService::check('user1');
// var_dump($info);
// echo "\r\n";
// exit;
class LockService
{
    
    //上锁
    public function lock($key, $time = 600) {
        $key = self::key($key);
        return redisModel::set($key, true, $time);
    }
    
    //解锁
    public function unlock($key) {
        $key = self::key($key);
        return redisModel::remove($key);
    }
    
    //校验
    public function check($key) {
        $key = self::key($key);
        return redisModel::get($key);
    }
    
    //统一前缀
    public function key($key) {
        return "LockService#transaction#{$key}";
    }
}
