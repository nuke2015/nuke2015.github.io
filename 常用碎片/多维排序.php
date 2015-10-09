<?php
class multi_sorter
{
    
    // 二维排序,按收藏时间
    public function sorter(&$CrondCache) {
        if ($CrondCache && count($CrondCache)) {
            foreach ($CrondCache as $value) {
                $collection_date[] = $value['collection_date'];
            }
            array_multisort($collection_date, SORT_DESC, $CrondCache);
        }
    }
    
    // 二维排序,按收藏时间
    public function multi_sorter(&$CrondCache) {
        if ($CrondCache && count($CrondCache)) {
            foreach ($CrondCache as $value) {
                $collection_date[] = $value['collection_date'];
                $collection_ids[] = $value['dishes_id'];
            }
            array_multisort($collection_date, SORT_DESC, $collection_ids, SORT_ASC, $CrondCache);
        }
    }
}
