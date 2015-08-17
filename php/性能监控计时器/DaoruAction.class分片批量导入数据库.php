<?php

/**
 * 首页接口
 */
class DaoruAction extends Action
{
    public function index() {
        set_time_limit(3600);
        for ($i = 0; $i < 80000; $i+= 10) {
            $data = $this->data($i);
            $this->insert($data);
        }
        echo 'done!';
        exit;
    }
    
    /**
     * 分批入库
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function insert($data) {
        $dishes_tags_sorter = D('dishes_tags_sorter');
        $dishes_tags_sorter->startTrans();
        if (count($data)) {
            foreach ($data as $key => $value) {
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
                }
            }
            $dishes_tags_sorter->commit();
        }
    }
    
    /**
     * 分片读取注意释放资源,不用file($filename)数组;
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    private function data($offset) {
        $filename = __DIR__ . '/i.csv';
        $result = array();
        
        $fp = fopen($filename, "r");
        while (!feof($fp)) {
            $i++;
            $line = fgets($fp);
            if ($i < $offset) continue;
            $result[] = trim($line);
            if ($i >= $offset + 10) break;
        }
        fclose($fp);
        return $result;
    }
}
