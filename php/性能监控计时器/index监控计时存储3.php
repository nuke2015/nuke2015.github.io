<?php

/**
 * 接口时间上报脚本
 * 这是监控计时存储的升级,
 * 本次升级目标是:减少文件读写开销,批量计数!
 * 2015年3月17日 10:31:14
 *
 * 本次升级目标是:二维计数器,每次请求互不交叉,各种请求分别累计.
 * 2015年3月17日 11:18:25;
 */

error_reporting(2047);

// 测试用例
if (file_exists('json.txt')) unlink('json.txt');
jsonlog::master('user/login');
for ($i = 0; $i < 100; $i++) {
    $key = rand(80000, 80100);
    $time = rand(10, 1000);
    jsonlog::insert($key, $time);
    echo "key:$key,time:$time<br>";
}
jsonlog::save();
$tmp = jsonlog::get();
dump($tmp);
exit;

//浏览器友好查看
function dump($v) {
    echo '<pre>';
    print_r($v);
    echo '</pre>';
}

/**
 *  日志操作类,
 *  调用:指定key名和每次消耗时间
 // 测试用例
 if (file_exists('json.txt')) unlink('json.txt');
 jsonlog::master('user/login');
 for ($i = 0; $i < 100; $i++) {
 $key = rand(80000, 80100);
 $time = rand(10, 1000);
 jsonlog::insert($key, $time);
 echo "key:$key,time:$time<br>";
 }
 jsonlog::save();
 $tmp = jsonlog::get();
 dump($tmp);
 exit;
 */
class jsonlog
{
    private static $file = 'json.txt';
    
    //单次请求大数组
    private static $db;
    
    //二维主键
    private static $master;
    
    //二维计时器,设置主键;
    public static function master($master) {
        self::$master = $master;
    }
    
    //单点计时;
    public static function insert($key, $time) {
        if (!self::$master) self::log(-1, 'master key pls!');
        self::$db = self::get();
        $data = & self::$db[self::$master];
        if (isset($data[$key])) {
            $data[$key]['r']+= 1;
            $data[$key]['t']+= $time;
            $data[$key]['m'] = max($time, $data[$key]['m']);
            $data[$key]['n'] = min($time, $data[$key]['n']);
        } 
        else {
            $data[$key]['r'] = 1;
            $data[$key]['t'] = $time;
            $data[$key]['m'] = $time;
            $data[$key]['n'] = $time;
        }
    }
    
    /**
     * 读文件;
     * @return [type] [description]
     */
    public static function get() {
        
        //内存加速
        if (self::$db) {
            return self::$db;
        } 
        else {
            
            //无数据时从数据库加载;
            if (file_exists(self::$file)) {
                $db = file_get_contents(self::$file);
                if ($db) {
                    return json_decode($db, 1);
                }
            }
        }
        return null;
    }
    
    /*
     * 批量内存计数,手动输出保存,减少文件读写次数;
     * 按主键保存数据;
    */
    public static function save() {
        file_put_contents(self::$file, json_encode(self::$db));
    }
    
    //日志操作方法
    private static function log($code, $msg) {
        echo "error number:{$code},error msg:{$msg}<br>";
        exit;
    }
}
