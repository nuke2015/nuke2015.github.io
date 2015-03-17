<?php
/**
 * 接口时间上报脚本
 * 监控计时脚本原型
 * 主要目标:批量计时,自动累计.
 */

error_reporting(2047);


// // 小测试
// jsonlog::log(10000, 50);
// jsonlog::log(10002, 45);
// jsonlog::log(10000, 45);
// jsonlog::log(10000, 66);
// $tmp = jsonlog::getFile();
// dump($tmp);
// exit;


// 大测试
if(file_exists('json.txt'))unlink('json.txt');
for ($i = 0; $i < 1000; $i++) {
    $key=rand(80000,80100);
    $time=rand(100,1000);
    jsonlog::log($key,$time);
    echo "key:$key,time:$time<br>";
    // dump(array('key'=>$key,'time'=>$time));
}
$tmp=jsonlog::getFile();
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
$tmp = jsonlog::getFile();
dump($tmp);
 *  
 */
class jsonlog
{
    private static $file = 'json.txt';
    
    //计时入口;
    public static function log($key, $time) {
        $data = self::getFile();
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
        self::setFile($data);
    }
    
    /**
     * 写文件;
     * @param [type] $data [description]
     */
    public static function setFile($data) {
        $data = json_encode($data);
        return file_put_contents(self::$file, $data);
    }
    
    /**
     * 读文件;
     * @return [type] [description]
     */
    public static function getFile() {
        if (file_exists(self::$file)) {
            $data = file_get_contents(self::$file);
            if ($data) {
                return json_decode($data, 1);
            }
        }
        return null;
    }
}
