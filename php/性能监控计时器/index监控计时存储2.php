<?php

/**
 * 接口时间上报脚本
 * 这是监控计时存储的升级,
 * 本次升级目标是:减少文件读写开销,批量计数!
 * 2015年3月17日 10:31:14
 */

error_reporting(2047);

// 大测试
if (file_exists('json.txt')) unlink('json.txt');
for ($i = 0; $i < 1000; $i++) {
    $key = rand(80000, 80100);
    $time = rand(100, 1000);
    jsonlog::log($key, $time);
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
 * 测试用例
 jsonlog::log(10000, 50);
 jsonlog::log(10002, 45);
 jsonlog::log(10000, 45);
 jsonlog::log(10000, 66);
 jsonlog::save();
 $tmp = jsonlog::getFile();
 dump($tmp);
 *
 */
class jsonlog
{
    private static $file = 'json.txt';
    private static $data;
    
    //内存存储;
    
    //计时入口;
    public static function log($key, $time) {
        self::$data = self::get();
        if (isset(self::$data[$key])) {
            self::$data[$key]['r']+= 1;
            self::$data[$key]['t']+= $time;
            self::$data[$key]['m'] = max($time, self::$data[$key]['m']);
            self::$data[$key]['n'] = min($time, self::$data[$key]['n']);
        } 
        else {
            self::$data[$key]['r'] = 1;
            self::$data[$key]['t'] = $time;
            self::$data[$key]['m'] = $time;
            self::$data[$key]['n'] = $time;
        }
    }
    
    /**
     * 保存结果;
     * 批量内存计数,手动输出保存,减少文件读写次数;
     * @param [type] $data [description]
     */
    public static function save() {
        return file_put_contents(self::$file, json_encode(self::$data));
    }
    
    /**
     * 读文件;
     * @return [type] [description]
     */
    public static function get() {
        
        //内存加速
        if (self::$data) {
            return self::$data;
        } 
        else {
            
            //无数据时从数据库加载;
            if (file_exists(self::$file)) {
                $data = file_get_contents(self::$file);
                if ($data) {
                    return json_decode($data, 1);
                }
            }
        }
        return null;
    }
}
