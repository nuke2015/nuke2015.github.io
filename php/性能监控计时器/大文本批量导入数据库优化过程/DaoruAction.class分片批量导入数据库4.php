<?php

/**
 * 首页接口
 * 用了大文本切片读取,不再加载全部内容
 * 出租车与高速路拥堵经验:
 * 有一种状态叫做-慢,就是快!
 */
class DaoruAction extends Action
{
    public function index() {
        set_time_limit(3600);
        $filename = __DIR__ . '/i.csv';
        $length = 10;
        for ($i = 0; $i < 80000; $i+= $length) {
            $data = $this->data($filename, $i, $length);
            if (count($data)) $this->insert($data);
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
                }
            }
            $dishes_tags_sorter->commit();
        }
    }
    
    /**
     * 分片读取注意释放资源,不用file($filename)数组;
     * 此处直接返回单行文本内容不拆分,
     * 而在业务消费处把文本拆分成数组,
     * 有利于当前函数功能复用.
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    private function data($filename, $offset, $length) {
        $result = array();
        $fp = fopen($filename, "r");
        while (!feof($fp)) {
            $i++;
            $line = fgets($fp);
            if ($i < $offset) continue;
            $result[] = trim($line);
            if ($i >= $offset + $length) break;
        }
        fclose($fp);
        return $result;
    }
}
