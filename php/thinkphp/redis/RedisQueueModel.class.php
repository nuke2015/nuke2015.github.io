<?php

// 左进左出的话,会遇到一个问题就是后进的数据,被先出了
// // 测试
// $RedisQueue = D('Redis', 'Queue');
// $v = $RedisQueue->lpush('abc', 'test' . time());
// var_dump($v);
// $v = $RedisQueue->lpop('abc');
// var_dump($v);
// $v = $RedisQueue->lrange('abc', 0, 1000);
// var_dump($v);

//搜索热词队列
class RedisQueueModel extends redisModel {
    const search_keyword_log_ok = 'search_keyword_log_ok';
    const search_keyword_log_empty = 'search_keyword_log_empty';
    const api_access_log = 'api_access_log';
    const user_talent_update = 'user_talent_update';
    
    // 左入
    public static function lpush($channel, $data) {
        $redis = self::conn();
        
        return $redis->lpush($channel, json_encode($data, JSON_UNESCAPED_UNICODE));
    }
    
    // 左出
    public static function lpop($channel) {
        $redis = self::conn();
        $txt = $redis->lpop($channel);
        return json_decode($txt, 1);
    }
    
    // 左出一批
    public static function lpop_batch($channel, $length = 10) {
        $count = 0;
        $result = array();
        // 条数不够并且有数据时,继续.
        while ($count < $length) {
            $data = self::lpop($channel);
            if (!$data) {
                break;
            } 
            else {
                $result[] = $data;
                $count++;
            }
        }
        return $result;
    }
    
    // 左区间
    public static function lrange($channel, $start, $stop) {
        $redis = self::conn();
        $data = $redis->lrange($channel, $start, $stop);
        if ($data && count($data)) {
            foreach ($data as & $value) {
                $value = json_decode($value, 1);
            }
            unset($value);
        }
        return $data;
    }
    
    // 右入
    public static function rpush($channel, $data) {
        $redis = self::conn();
        return $redis->rpush($channel, json_encode($data, JSON_UNESCAPED_UNICODE));
    }
    
    // 右出
    public static function rpop($channel, $txt) {
        $redis = self::conn();
        $txt = $redis->rpop($channel);
        return json_decode($txt, 1);
    }
    
    // 右段
    public static function rrange($channel, $start, $stop) {
        $redis = self::conn();
        $data = $redis->rrange($channel, $start, $stop);
        if ($data && count($data)) {
            foreach ($data as & $value) {
                $value = json_decode($value, 1);
            }
            unset($value);
        }
        return $data;
    }
    
    // 长度
    public static function llen($channel) {
        $redis = self::conn();
        return $redis->llen($channel);
    }
    
    // 删除
    public static function lrem($channel, $count, $value) {
        $redis = self::conn();
        return $redis->lrem($channel, $count, $value);
    }
    
    // 节选
    public static function ltrim($channel, $start, $stop) {
        $redis = self::conn();
        return $redis->ltrim($channel, $start, $stop);
    }
}
