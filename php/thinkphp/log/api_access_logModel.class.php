<?php

/**
 * 日志模块
 */
class api_access_logModel extends Model
{
    protected $dbName = 'api';
    protected $trueTableName = 'api_access_log';
    public static $log_data = array();
    
    //登记
    public static function sign($tag) {
        self::$log_data[$tag] = microtime(1);
    }
    
    //耗时
    public function spent($tag1, $tag2) {
        $log_data = self::$log_data;
        if (isset($log_data[$tag1]) && isset($log_data[$tag2])) {
            return round(($log_data[$tag1] - $log_data[$tag2]), 4) * 1000;
        } else {
            return -1;
        }
    }
    
    /**
     * 保存
     * @return [type] [description]
     */
    public function save($title, $logdata, $ip, $useragent, $spent) {
        $insert = array();
        $insert['title'] = $title;
        $insert['data'] = json_encode($logdata);
        $insert['ip'] = $ip;
        $insert['useragent'] = $useragent;
        $insert['spent'] = $spent;
        $insert['create_time'] = time();
        return $this->data($insert)->add();
    }
}
