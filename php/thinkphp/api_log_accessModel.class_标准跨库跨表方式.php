<?php

// api_access_logModel::sign('start');
// api_access_logModel::sign('stop');
// $spent = api_access_logModel::spent('stop', 'start');
// try {
//     $title = trim($_POST['methodName']);
//     $api_access_log = D('api_access_log');
//     $user_agent = trim($_SERVER['HTTP_USER_AGENT']);
//     $param = array('request' => $_POST, 'response' => $return);
//     $ip = get_client_ip();
//     $api_access_log->save($title, $param, $ip, $user_agent, $spent);
// }
// catch(Exception $e) {
// }



/**
 * 日志模块
 */
class api_log_accessModel extends Model
{
    protected $dbName = 'api';
    protected $trueTableName = 't_api_log_access';
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
        if (ENV_ONLINE) {
            
            //线上走文件
            $status = log_json($title, $insert, 'Access');
        } else {
            
            //开发走数据库
            $status = $this->data($insert)->add();
        }
        return $status;
    }
}
