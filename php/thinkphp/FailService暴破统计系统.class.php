<?php

/**
 *  暴破统计系统
 */

// //测试
// import("@.Service.FailService");
// $FailService = new FailService($sig);

// //每1s秒钟检查,达到3次锁定,锁定2s秒
// $qps = $FailService->qps(1, 3, 2);

// $log = $FailService->result();
// var_dump($qps);

// --->2015-12-28_23-21-08 this UserAuthAction#code_check#locker_start 127.0.0.1 /<---
// Array
// (
//     [createtime] => 1451316066
//     [total] => 4
//     [updatetime] => 1451316068
//     [timeline] => Array
//         (
//             [0] => 1451316067
//             [1] => 1451316067
//             [2] => 1451316068
//         )

//     [len] => 2
//     [qps] => 2
// )

class FailService
{
    private static $sid;
    
    public function __construct($sid) {
        self::$sid = $sid;
    }
    
    //统计入库
    public function sign($per_time) {
        $diffkey = $this->key();
        $timenow = time();
        
        $data = redisModel::get($diffkey);
        if ($data && count($data)) {
            $data['total']+= 1;
            $data['len'] = $data['updatetime'] - $data['createtime'] + 1;
            $data['qps'] = round($data['total'] / $data['len'], 3);
            
            // 先计算再更新
            $data['updatetime'] = $timenow;
            $data['timeline'][] = $timenow;
        } else {
            $data = array('createtime' => $timenow, 'total' => 1, 'updatetime' => $timenow);
            $data['timeline'] = array();
        }
        
        //若自动归零,会产生多次日志.所以,选择手动归零.
        redisModel::set($diffkey, $data, $per_time);
        return $data;
    }
    
    //状态识别
    public function check() {
        $diffkey = $this->key();
        $data = redisModel::get($diffkey);
        return $data;
    }
    
    //归零
    public function remove() {
        $diffkey = $this->key();
        return redisModel::remove($diffkey);
    }
    
    //结果输出
    public function result() {
        $data = $this->check();
        if ($data && count($data)) {
            $data['createtime'] = date("Y-m-d H:i:s", $data['createtime']);
            $data['updatetime'] = date("Y-m-d H:i:s", $data['updatetime']);
        }
        return $data;
    }
    
    // 封禁
    public function locker($len = 86400) {
        $diffkey = 'locker#' . $this->key();
        redisModel::set($diffkey, 1, $len);
    }
    
    // 查号
    public function locking() {
        $diffkey = 'locker#' . $this->key();
        $locker = redisModel::get($diffkey);
        if ($locker) {
            return true;
        } else {
            return false;
        }
    }
    
    //统一key值
    public function key() {
        return "FailService#" . self::$sid;
    }
    
    //服务QPS,10/60s
    public function qps($per_time = 1, $lock_total = 10, $lock_time = 60) {
        
        // 是否封号中
        if ($this->locking()) return true;
        
        // 签到
        $this->sign($per_time);
        
        //频率检查
        $data_fail = $this->check();
        if ($data_fail && count($data_fail)) {
            
            // 超过10次,触发报警
            if ($data_fail['total'] > $lock_total) {
                
                //惩罚,锁住一小时
                $this->locker($lock_time);
                
                vlog('QPS#locker_start#' . self::$sid, $data_fail, 'failservice');
                return true;
            }
        }
        
        return false;
    }
}
