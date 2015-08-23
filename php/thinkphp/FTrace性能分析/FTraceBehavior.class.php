<?php
defined('THINK_PATH') or exit();

/**
 * 业务性能分析
 */
class FTraceBehavior extends Behavior
{
    
    //[txt,json]
    private $logtype = 'json';
    
    // 行为扩展的执行入口必须是run
    public function run(&$params) {
        
        //FTrace_logtype日志形式:[json,txt];
        $logtype = C('FTrace_logtype');
        if ($logtype) $this->logtype = $logtype;
        
        //FTrace_tags日志标签:['FILES','BASE','SQL', 'NOTIC', 'INFO'];
        $tags = C('FTrace_tags');
        if (!count($tags)) $tags = array('FILES', 'BASE', 'SQL', 'NOTIC', 'INFO');
        
        //记录标签;
        $trace = $this->trace($tags);
        
        //文件列表
        if (in_array('FILES', $tags)) {
            $trace['FILES'] = $this->files();
        }
        
        //基本信息
        if (in_array('BASE', $tags)) {
            $trace['BASE'] = $this->base();
        }
        
        $this->log($trace);
    }
    
    // 加载文件;
    private function files() {
        $files = get_included_files();
        $info = array();
        foreach ($files as $key => $file) {
            $info[] = $file . ' ( ' . number_format(filesize($file) / 1024, 2) . ' KB )';
        }
        return $files;
    }
    
    //基本信息;
    private function base() {
        $base = array('请求信息' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . ' ' . $_SERVER['SERVER_PROTOCOL'] . ' ' . $_SERVER['REQUEST_METHOD'] . ' : ' . __SELF__, '运行时间' => $this->showTime(), '吞吐率' => number_format(1 / G('beginTime', 'viewEndTime'), 2) . 'req/s', '内存开销' => MEMORY_LIMIT_ON ? number_format((memory_get_usage() - $GLOBALS['_startUseMems']) / 1024, 2) . ' kb' : '不支持', '查询信息' => N('db_query') . ' queries ' . N('db_write') . ' writes ', '文件加载' => count(get_included_files()), '缓存信息' => N('cache_read') . ' gets ' . N('cache_write') . ' writes ', '配置加载' => count(c()), '会话信息' => 'SESSION_ID=' . session_id(),);
        return $base;
    }
    
    //跟踪信息;
    private function trace($tags = array()) {
        $result = array();
        foreach (trace() as $key => $value) {
            if (in_array($key, $tags)) $result[$key] = $value;
        }
        return $result;
    }
    
    //获取运行时间
    private function showTime() {
        
        // 显示运行时间
        G('beginTime', $GLOBALS['_beginTime']);
        G('viewEndTime');
        
        // 显示详细运行时间
        return G('beginTime', 'viewEndTime') . 's ( Load:' . G('beginTime', 'loadTime') . 's Init:' . G('loadTime', 'initTime') . 's Exec:' . G('initTime', 'viewStartTime') . 's Template:' . G('viewStartTime', 'viewEndTime') . 's )';
    }
    
    //输出;
    private function log($data) {
        if ($this->logtype == 'json') {
            $str = json_encode($data);
        } else {
            $str = print_r($data, 1);
        }
        $str.= "\r\n\r\n";
        $filename = "ftrace" . date("Y_m_d_H") . '.log';
        file_put_contents($filename, $str, FILE_APPEND);
    }
}
