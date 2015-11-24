<?php

/**
 *  暴破统计系统
 */

// Array
// (
//     [createtime] => 1448347866
//     [total] => 3
//     [updatetime] => 1448347866
//     [timeline] => Array
//         (
//             [0] => 1448347866
//             [1] => 1448347866
//             [2] => 1448347866
//         )

// )
// //暴破统计系统
// $FailService=D('Fail','Service');
// $FailService->remove(1);
// $FailService->sign(1);
// $dd=$FailService->sign(1);
// print_r($dd);

// $FailService->sign(1);
// $data=$FailService->check(1);
// print_r($data);
// exit;

class FailService {
    
    //统计入库
    public function sign($user_id) {
        $diffkey = $this->key($user_id);
        $timenow = time();
        
        $data = redisModel::get($diffkey);
        if ($data && count($data)) {
            $data['total']+= 1;
            $data['updatetime'] = $timenow;
            $data['timeline'][] = $timenow;
        } 
        else {
            $data = array('createtime' => $timenow, 'total' => 1, 'updatetime' => $timenow);
            $data['timeline'] = array();
        }
        redisModel::set($diffkey, $data);
        return $data;
    }
    
    //状态识别
    public function check($user_id) {
        $diffkey = $this->key($user_id);
        $data = redisModel::get($diffkey);
        return $data;
    }
    
    //归零
    public function remove($user_id) {
        $diffkey = $this->key($user_id);
        return redisModel::remove($diffkey, $data);
    }
    
    //统一key值
    public function key($user_id) {
        return "FailService#" . $user_id;
    }
}
