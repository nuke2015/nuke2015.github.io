<?php

// 测试用例
// import("@.Service.CrondService");
// CrondService::crond_set('dishes', $dishes_id, 'play_count', 1);
// CrondService::crond_set('dishes', $dishes_id, 'click_count', 1);
// $data = CrondService::crond_get('dishes');
// print_r($data);
// exit;

// // 一维数据测试
// import("@.Service.CrondService");
// CrondService::bucket_push('search_id', '苹果');
// CrondService::bucket_push('search_id', '香焦');
// $data = CrondService::bucket_get('search_id');
// print_r($data);
// exit;



/**
 * 批处理任务服务层
 */
class CrondService
{
    
    //相关数据的批量存入redis,等同于mysql表结构
    public static function crond_set($bucket, $id, $k, $v) {
        $bucket.= 'crond';
        $diffkey = self::key($bucket);
        $id = intval($id);
        $store = redisModel::get($diffkey);
        if (isset($store[$id][$k])) {
            $store[$id][$k] = $store[$id][$k] + $v;
        } 
        else {
            $store[$id][$k] = $v;
        }
        return redisModel::set($diffkey, $store);
    }
    
    //相关数据的批量取出,等同于mysql表结构
    public static function crond_get($bucket, $clean = 0) {
        $bucket.= 'crond';
        $diffkey = self::key($bucket);
        $store = redisModel::get($diffkey);
        if ($clean) redisModel::remove($diffkey);
        return $store;
    }
    
    //寄存器.统一命名,避免碰撞
    private static function key($key) {
        $diffkey = "CrondService#redis#{$key}";
        return $diffkey;
    }
    
    //批量入库
    public static function set_inc($tablename) {
        $store = self::crond_get($tablename, true);
        if (count($store)) {
            $dao = D($tablename);
            $pk = $dao->getPk();
            $trueTableName = $dao->trueTableName;
            $dao->startTrans();
            foreach ($store as $id => $data) {
                if (count($data)) {
                    $id = intval($id);
                    $sqls = array();
                    foreach ($data as $k => $v) {
                        $sqls[] = "{$k}={$k}+{$v}";
                    }
                    $update = implode(',', $sqls);
                    $dao->execute("UPDATE {$trueTableName} SET {$update} WHERE {$pk} = {$id};");
                }
            }
            $dao->commit();
        }
        return $store;
    }
    
    //一维数据入栈
    public static function bucket_push($bucket, $value) {
        $bucket.= 'bucket';
        $diffkey = self::key($bucket);
        $store = redisModel::get($diffkey);
        if (!$store) {
            $store = array();
        }
        array_push($store, $value);
        return redisModel::set($diffkey, $store);
    }
    
    //一维数据出栈
    public static function bucket_get($bucket, $clean = 0) {
        $bucket.= 'bucket';
        $diffkey = self::key($bucket);
        $store = redisModel::get($diffkey);
        if ($clean) redisModel::remove($diffkey);
        return $store;
    }
}
