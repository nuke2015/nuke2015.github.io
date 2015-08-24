<?php

// 测试代码
// import("@.ORG.FTrace");
// $info=FTrace::info();
// print_r($info);
// exit;



/**
 * 业务性能分析静态类,可在任何地方调用
 * 如果是统计mysql,一定是在mysql执行以后.
 * 
 * 为什么:
 * 原来的追踪配合thinkphp的behavior对运行节点有要求,
 * 比如app_begin,app_end等
 * 如果,是api提前结束exit了,时间节点调用就不存在.
 * 所以用起来非常不方便.
 * 之前测试到echo json_encode();exit;后没日志.
 * 而$this->display();后却有日志.
 * 说明,时间节点的挂载耦合太严重了.
 * 于是改进了这个版本,做为第三方类直接引入,
 * 在想要监控的地方直接监控,需要监控什么内容,就监控什么内容.
 * 
 */
class FTrace
{
    
    //[txt,json]
    private $logtype = 'txt';
    
    //全部信息
    public static function info($tags) {
        
        //FTrace_tags日志标签:['FILES','BASE','SQL', 'NOTIC', 'INFO'];
        if (!count($tags)) {
            $tags = array('FILES', 'BASE', 'SQL', 'NOTIC', 'INFO');
        }
        
        //记录标签;
        $trace = self::trace($tags);
        
        //文件列表
        if (in_array('FILES', $tags)) {
            $trace['FILES'] = self::files();
        }
        
        //基本信息
        if (in_array('BASE', $tags)) {
            $trace['BASE'] = self::base();
        }
        return $trace;
    }
    
    // 加载文件;
    public static function files() {
        $files = get_included_files();
        $info = array();
        foreach ($files as $key => $file) {
            $info[] = $file . ' ( ' . number_format(filesize($file) / 1024, 2) . ' KB )';
        }
        return $files;
    }
    
    //基本信息;
    public function base() {
        $base = array('请求信息' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . ' ' . $_SERVER['SERVER_PROTOCOL'] . ' ' . $_SERVER['REQUEST_METHOD'] . ' : ' . __SELF__, '运行时间' => self::showTime(), '吞吐率' => number_format(1 / G('beginTime', 'viewEndTime'), 2) . 'req/s', '内存开销' => MEMORY_LIMIT_ON ? number_format((memory_get_usage() - $GLOBALS['_startUseMems']) / 1024, 2) . ' kb' : '不支持', '查询信息' => N('db_query') . ' queries ' . N('db_write') . ' writes ', '文件加载' => count(get_included_files()), '缓存信息' => N('cache_read') . ' gets ' . N('cache_write') . ' writes ', '配置加载' => count(c()), '会话信息' => 'SESSION_ID=' . session_id(),);
        return $base;
    }
    
    //跟踪信息;
    public function trace($tags = array()) {
        $result = array();
        foreach (trace() as $key => $value) {
            if (in_array($key, $tags)) $result[$key] = $value;
        }
        return $result;
    }
    
    //获取运行时间
    private static function showTime() {
        
        // 显示运行时间
        G('beginTime', $GLOBALS['_beginTime']);
        G('viewEndTime');
        
        // 显示详细运行时间
        return G('beginTime', 'viewEndTime') . 's ( Load:' . G('beginTime', 'loadTime') . 's Init:' . G('loadTime', 'initTime') . 's Exec:' . G('initTime', 'viewStartTime') . 's Template:' . G('viewStartTime', 'viewEndTime') . 's )';
    }
}
