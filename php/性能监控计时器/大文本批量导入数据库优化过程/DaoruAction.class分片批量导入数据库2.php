<?php

/**
 * 首页接口
 * 减少事务的内存,每10条入一次
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
                $i++;
                $arr = explode(',', $value);
                if (count($arr) != 8) print_r($value);
                $data = array();
                $data['id'] = $arr[0];
                $data['tag_id'] = $arr[1];
                $data['tag_name'] = $arr[2];
                $data['dishes_id'] = $arr[3];
                $data['dishes_name'] = $arr[4];
                $data['listorder'] = $arr[5];
                $data['status'] = $arr[6];
                $data['last_update'] = date("Y-m-d H:i:s");
                try {
                    $dishes_tags_sorter->data($data)->add();
                }
                catch(Exception $e) {
                    dump($value);
                }
                if ($i > 10) {
                    $i = 0;
                    $dishes_tags_sorter->commit();
                }
            }
            $dishes_tags_sorter->commit();
        }
    }
}
