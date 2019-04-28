<?php

// 工厂模式
require_once __DIR__ . '/BaseStore.php';

// //永久存储+定时更新
// import("@.Store.SearchHot");
// $SearchHot = D('SearchHot', 'Store');
// // 取数据
// $result = $SearchHot->CrondCache(0);
// // 更新数据
// $result = $SearchHot->CrondCache(1);

class SearchHotStore extends BaseStore
{
    
    // 子类实现具体的取数据逻辑,必须是需要缓存的,最有价值的数据
    public function get_data($diffkey = '') {
        $search_id = D('search_id');
        
        // 请注意:
        // 此处不做条数控制,在外围业务层Controll节选条数,能定制输出n条.
        // 但是热词的实际总条数,还是由数据层Model决定
        // 这里只是中间存储,只是优化,不改变业务的本身逻辑
        return $search_id->hotword();
    }
}
