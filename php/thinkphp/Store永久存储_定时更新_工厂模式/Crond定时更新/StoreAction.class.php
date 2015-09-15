<?php

/**
 * redis里面的永久存储定时更新
 */
class StoreAction extends BaseAction
{
    public function index() {
        $store_keys = array();
        $store_keys[] = 'MaterialConfig';
        print_r($store_keys);
        exit;
    }
    
    //食材分类树
    public function MaterialConfig() {
        import("@.Store.MaterialConfig");
        $MaterialConfig = D('MaterialConfig', 'Store');
        $info = $MaterialConfig->CrondCache(1);
        print_r($info);
        vlog('MaterialConfig', $info, 'store');
    }
    
    //食材分类树
    public function SearchHot() {
        import("@.Store.SearchHot");
        $SearchHot = D('SearchHot', 'Store');
        $info = $SearchHot->CrondCache(1);
        print_r($info);
        vlog('SearchHot', $info, 'store');
    }
    
    //食材组合搜索
    public function SearchMix() {
        $materialModel = D('material');
        $material_ids = $materialModel->get_publish();
        
        import("@.Store.SearchMix");
        $SearchMix = D('SearchMix', 'Store');
        if ($material_ids && count($material_ids)) {
            foreach ($material_ids as $material_id) {
                $info = $SearchMix->CrondCache(1, $material_id);
                $this->flush(json_encode($info));
                vlog("SearchMix_material_{$material_id}_dishes_ids", $info, 'store');
            }
        }
        vlog('SearchMix_material_publish', $material_ids, 'store');
    }
}
