<?php

/**
 * 首页接口
 * 使用了数组切片,不存储8万条大数组
 */
class DaoruAction extends BaseAction
{
    public function index() {
        set_time_limit(3600);
        $length=10;
        for($i=0;$i<80000;$i+=$length){
            $data=$this->data($i,$length);
            if(count($data)){
                $this->insert($data);
            }
        }
        echo 'done!';
    }

    /**
     * 入库
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function insert($data){    
        $dishes_tags_sorter = D('dishes_tags_sorter');
        $dishes_tags_sorter->startTrans();
        if (count($data)) {
            foreach ($data as $key => $value) {
                $i++;
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
                if ($i > 10) {
                    $i = 0;
                    $dishes_tags_sorter->commit();
                }
            }
            $dishes_tags_sorter->commit();
        }
    }
    
    /**
     * 数据
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    private function data($i,$length) {
        $filename = __DIR__ . '/i.csv';
        $data = file($filename);
        $data = array_slice($data, $i, $length);
        return $data;
    }
}
