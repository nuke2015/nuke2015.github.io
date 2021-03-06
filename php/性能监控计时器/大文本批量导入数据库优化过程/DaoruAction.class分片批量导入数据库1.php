<?php

/**
 * 首页接口
 * 数据直接导,用了mysql事务
 */
class DaoruAction extends BaseAction
{
    public function index() {
        set_time_limit(3600);
        
        $filename = __DIR__ . '/i.csv';
        $data = file($filename);
        $dishes_tags_sorter = D('dishes_tags_sorter');
        $dishes_tags_sorter->startTrans();
        if (count($data)) {
            foreach ($data as $key => $value) {
                $arr = explode(',', $value);
                if (count($arr) != 8) print_r($value);
                $insert = array();
                $insert['id'] = $arr[0];
                $insert['tag_id'] = $arr[1];
                $insert['tag_name'] = $arr[2];
                $insert['dishes_id'] = $arr[3];
                $insert['dishes_name'] = $arr[4];
                $insert['listorder'] = $arr[5];
                $insert['status'] = $arr[6];
                $insert['last_update'] = date("Y-m-d H:i:s");
                try {
                    $dishes_tags_sorter->data($insert)->add();
                }
                catch(Exception $e) {
                    dump($value);
                }
            }
            $dishes_tags_sorter->commit();
        }
    }
}
