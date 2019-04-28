<?php

// 工厂模式
// 子类加功能实现的时候,不会影响历史的功能脚本

// 测试用例
// 增加一个SearchHot类,继承自BaseStore类,同时自定义实现get_data方法.
//
// //永久存储+定时更新
// import("@.Store.SearchHot");
// $SearchHot = D('SearchHot', 'Store');
// // 取数据
// $result = $SearchHot->CrondCache(0);
// // 更新数据
// $result = $SearchHot->CrondCache(1);
abstract class BaseStore
{
    public $cache_key = '';
    
    // 实时取数据,需要继承者主动实现
    abstract public function get_data($diffkey = '');
    
    // 无数据时动态生成,可强制异步更新
    public function CrondCache($force_update, $diffkey = '') {
        
        // 增加缓存标识,必须是子类名
        $class_name = "Store#CrondCache#";
        $class_name.= get_class($this);
        $class_name.= "#" . $diffkey;
        $result = redisModel::get($class_name);
        if (!$result || $force_update) {
            
            // 要把$diffkey透传过去
            $result = $this->get_data($diffkey);
            
            // 永久存储,强制刷新
            redisModel::set($class_name, $result);
        }
        return $result;
    }
}
