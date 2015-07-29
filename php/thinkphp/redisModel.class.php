<?php

//测试用例
// redisModel::set('test','hello world');
// redisModel::set('test',$_SERVER);
// redisModel::set('test',time(),5);
// $data=redisModel::get('test');
// print_r($data);
// exit;

// 配置信息
// 'DATA_CACHE_TYPE'=>'Redis',
// 'REDIS_HOST'=>'192.168.1.235',
// 'REDIS_PORT'=>'6379',
// 'DATA_CACHE_TIMEOUT'=>'30',
// 'DATA_CACHE_PREFIX'=>'API_',
class redisModel
{
    static $redis;
    
    /**
     * 连接数据库
     * @return [type] [description]
     */
    public static function conn() {
        self::$redis = new redis();
        self::$redis->connect(C('REDIS_HOST'), C('REDIS_PORT'));
        return self::$redis;
    }
    
    /**
     * 提取
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function get($key) {
        $key = self::modify_key($key);
        $redis = self::conn();
        $value = $redis->get($key);
        return unserialize($value);
    }
    
    /**
     * 保存
     * @param [type]  $key    [description]
     * @param [type]  $value  [description]
     * @param integer $expire [description]
     */
    public static function set($key, $value, $expire = 0) {
        $key = self::modify_key($key);
        $redis = self::conn();
        $value = serialize($value);
        if ($expire > 0) {
            $redis->setex($key, $expire, $value);
        } else {
            $redis->set($key, $value);
        }
    }
    
    /**
     * 删除
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function remove($key) {
        $key = self::modify_key($key);
        $redis = self::conn();
        $redis->delete($key);
    }
    
    /**
     * 键名修饰
     */
    private static function modify_key($key) {
        $prefix = C('DATA_CACHE_PREFIX');
        $key = $prefix . md5($key);
        return $key;
    }
}
