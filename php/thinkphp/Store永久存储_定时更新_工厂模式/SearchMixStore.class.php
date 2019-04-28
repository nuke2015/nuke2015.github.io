<?php

// 工厂模式
require_once __DIR__ . '/BaseStore.php';

// //永久存储+定时更新
// import("@.Store.SearchMix");
// $SearchMix = D('SearchMix', 'Store');
// // 取数据
// $result = $SearchMix->CrondCache(0,36);
// // 更新数据
// $result = $SearchMix->CrondCache(1,36);

class SearchMixStore extends BaseStore
{
    public $cache_key = '';
    
    // 子类实现具体的取数据逻辑,必须是需要缓存的,最有价值的数据
    public function get_data($material_id = 0) {
        
        //material_id!=0 but abstract class need the struct;
        if ($material_id == 0) return;
        
        // 校准缓存位
        $this->cache_key = $material_id;
        
        $material_id = intval($material_id);
        $dishesModel = D('dishes');
        $info = $dishesModel->get_dishes_by_material($material_id);
        return $info;
    }
    
    // 根据食材id取菜的id列表,并做交集
    public function get_dishes_by_material_with_intersect($material_ids) {
        
        // 弹出首值
        $result = array();
        $material_id = array_shift($material_ids);
        $result = $this->CrondCache(0, $material_id);
        
        // 做交集
        if ($material_ids && count($material_ids)) {
            foreach ($material_ids as $material_id) {
                $result_more = $this->CrondCache(0, $material_id);
                $result = array_intersect($result, $result_more);
            }
        }
        return $result;
    }
}
