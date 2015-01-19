<?php
use gb_php\diary\SceneDiaryService as SceneDiaryService;
use ThriftClient as ThriftClient;

class thrift
{
    
    /**
     * JAVA-RPC服务接口;
     * @return [type] [description]
     */
    static public function getResult($methodName, $param) {
        
        //java-RPC
        require_once ROOT . "/gb_php/diary/SceneDiaryService.php";
        
        $return = array();
        $logdata['methodName'] = $methodName;
        $logdata['param'] = $param;
        
        //这里不try因为没必要
        try {
            $SceneDiaryServiceEx = SceneDiaryService::getInstance();
            $rtime = new runtime();
            $rtime->start();
            $return = $SceneDiaryServiceEx->getResult($methodName, $param);
            $rtime->stop();
            
            //统计接口时间;
            $logdata['runtime'] = (float)$rtime->spent();
            if (defined('LOG_THRIFT') && LOG_THRIFT) {
                try {
                    
                    //改为try,避免日志行为影响接口调用.
                    $Mlogger = new Mlogger('LOGV2_THRIFT');
                    $title = $methodName;
                    $Mlogger->logRequest($title, $logdata);
                    unset($log);
                }
                catch(Exception $ex) {
                    Mlogger::monolog('Mlogger io fail', $ex->getMessage());
                }
            }
        }
        catch(Exception $ex) {
            Mlogger::monolog('THRIFT NO SERVICE', $ex->getMessage());
        }
        return $return;
    }
    
    /**
     * JAVA-THRIFT类构造;
     * @param  [type] $tname [description]
     * @param  [type] $data  [description]
     * @param  [type] $key   [是否包含键名]
     * @return [type]        [description]
     */
    static public function module($tname, $data, $key = true) {
        $result = array('classname' => "module\\$tname", 'property' => $data);
        $tname = strtolower(substr($tname, 1));
        if ($key) {
            $result = array($tname => $result);
        }
        return $result;
    }
    
    /**
     * JAVA-THRIFT类构造;
     * @param  [type] $tname [description]
     * @param  [type] $data  [description]
     * @param  [type] $key   [是否包含键名]
     * @return [type]        [description]
     */
    static public function advanced($tname, $data, $key = true) {
        $result = array('classname' => "advanced\\$tname", 'property' => $data);
        $tname = strtolower(substr($tname, 1));
        if ($key) {
            $result = array($tname => $result);
        }
        return $result;
    }
    
    /**
     * 封装thriftClient的实例化;
     */
    public static function instance($Server) {
        require_once __DIR__ . '/ThriftClient.php';
        return ThriftClient\Server::instance($Server);
    }
    
    /**
     * 封装thriftClient相关的调用
     */
    public static function getClient($Server, $methodName, $param) {
        $result = array();
        require_once __DIR__ . '/ThriftClient.php';
        if (is_array($param)) {
            
            //多参数归一;
            $result = call_user_func_array(array(self::instance($Server), $methodName), $param);
        }
        return $result;
    }
    
    /**
     * 封装业主后台的相关调用;
     * 测试:
     * thrift::yz('getItemsByUid',4655,1);
     */
    public static function yz() {
        
        //拆参;
        $args = func_get_args();
        $result = array();
        if (is_array($args) && (count($args) > 0)) {
            $methodName = $args[0];
            array_shift($args);
            return self::getClient('YzService', $methodName, $args);
        } else {
            return array();
        }
    }
}
