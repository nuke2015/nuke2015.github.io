<?php

// 工厂模式
require_once __DIR__ . '/BaseStore.php';


// //永久存储+定时更新
// import("@.Store.MaterialConfig");
// $MaterialConfigStore = D('MaterialConfig', 'Store');
// // 取数据
// $result = $MaterialConfigStore->CrondCache(0);
// // 更新数据
// $result = $MaterialConfigStore->CrondCache(1);

class MaterialConfigStore extends BaseStore
{
    
    // 子类实现具体的取数据逻辑,必须是需要缓存的,最有价值的数据
    public function get_data($diffkey='') {
        $materialModel = D('material');
        return $materialModel->get_config();
    }
}
