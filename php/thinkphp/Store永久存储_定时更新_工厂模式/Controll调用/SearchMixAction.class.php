<?php

/**
 * 食材组合搜索
 */
class SearchMixAction extends BaseAction
{
    public function index() {
        $user_id = intval($_POST['user_id']);
        
        //默认第一页;
        $page = intval($_POST['page']);
        if ($page < 1) {
            $page = 1;
        }
        
        //默认每页10条;
        $size = intval($_POST['size']);
        if (!$size) {
            $size = 10;
        }
        
        $ids_material = array();
        $material_ids = explode(',', $_POST['material_ids']);
        
        //数据校验
        if ($material_ids && count($material_ids)) {
            foreach ($material_ids as $value) {
                if (intval($value)) $ids_material[] = intval($value);
            }
            
            // 不准太消耗性能
            if (count($ids_material) > 5) {
                $this->result(ERR_WRONG_ARG);
            }
        } 
        else {
            $this->result(ERR_WRONG_ARG);
        }
        
        // 永久存储+定时更新
        import("@.Store.SearchMix");
        $SearchMix = D('SearchMix', 'Store');
        
        // 得到全量数据
        $ids_dishes = $SearchMix->get_dishes_by_material_with_intersect($material_ids);
        $total = count($ids_dishes);
        
        // 手动分页
        import("@.ORG.Page");
        $Page_helper = new Page($total, $size, $page);
        $ids_dishes = array_slice($ids_dishes, $Page_helper->firstRow, $Page_helper->listRows);
        
        // 取实体
        $dishesModel = D('dishes');
        $result = $dishesModel->get_dishes_by_ids($ids_dishes);
        
        $return = array('page' => strval($Page_helper->nowPage), 'size' => strval($Page_helper->listRows), 'total' => strval($total), 'count' => strval(count($result)), 'data' => $result);
        
        $this->result(ERR_NONE, $return);
    }
}
