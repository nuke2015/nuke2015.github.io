<?php

// 用redis架设模拟数据库
class IndexAction extends Action
{
    
    //条件查找+分页
    public function index() {
        $table = 'news';
        $idx = F("index#{$table}");
        $result = $sort = array();
        if ($idx && count($idx)) {
            foreach ($idx as $id) {
                $tmp_data = F("data#{$table}#{$id}");
                if ($tmp_data['code'] > 50) {
                    $result[$id] = $id;
                    $sort[$id] = $tmp_data['code'];
                }
            }
            array_multisort($sort, SORT_ASC, $result);
        }
        dump($result);
        if ($result && count($result)) {
            $result_page = array_slice($result, 0, 3);
            $result_page2 = array_slice($result, 3, 3);
        }
        dump($result_page);
        dump($result_page2);
        $data = $this->get_by_ids($result_page2);
        dump($data);
        exit;
    }
    
    //取一批
    public function get_by_ids($ids) {
        $table = 'news';
        $result = array();
        if ($ids && count($ids)) {
            foreach ($ids as $id) {
                $result[$id] = F("data#{$table}#{$id}");
            }
        }
        return $result;
    }
    
    //条件查找+排序
    public function where() {
        $table = 'news';
        $idx = F("index#{$table}");
        $result = array();
        $sort = array();
        if ($idx && count($idx)) {
            foreach ($idx as $id) {
                $tmp = F("data#{$table}#{$id}");
                if ($tmp['code'] > 10) {
                    $result[$id] = $tmp;
                    $sort[$id] = $tmp['code'];
                }
            }
        }
        
        // array_multisort($sort,SORT_ASC,$result);
        array_multisort($sort, SORT_DESC, $result);
        dump($result);
        exit;
    }
    
    //添加测试
    public function test_add() {
        $this->add('news', $this->test_make());
        $this->add('news', $this->test_make());
        $this->add('news', $this->test_make());
        $this->add('news', $this->test_make());
        $ind = F("index#news");
        dump($ind);
    }
    
    //生成测试数据
    public function test_make() {
        return array('title' => 'the title', 'code' => rand(0, 100), 'time' => time());
    }
    
    //添加数据
    public function add($table, $data) {
        $mongoid = $this->mongo_id();
        F("data#{$table}#{$mongoid}", $data);
        $this->push("index#{$table}", $mongoid);
        return $mongoid;
    }
    
    //挤入
    public function push($k, $v) {
        $data = F($k);
        if (!$data) $data = array();
        $data[] = $v;
        F($k, $data);
    }
    
    // 生成类似mongo主键的函数
    public function mongo_id() {
        static $i = 0;
        $i OR $i = mt_rand(1, 0x7FFFFF);
        
        return sprintf("%08x%06x%04x%06x",
        
        /* 4-byte value representing the seconds since the Unix epoch. */
        time() & 0xFFFFFFFF,
        
        /* 3-byte machine identifier.
         *
         * On windows, the max length is 256. Linux doesn't have a limit, but it
         * will fill in the first 256 chars of hostname even if the actual
         * hostname is longer.
         *
         * From the GNU manual:
         * gethostname stores the beginning of the host name in name even if the
         * host name won't entirely fit. For some purposes, a truncated host name
         * is good enough. If it is, you can ignore the error code.
         *
         * crc32 will be better than Times33. */
        crc32(substr((string)gethostname(), 0, 256)) >> 8 & 0xFFFFFF,
        
        /* 2-byte process id. */
        getmypid() & 0xFFFF,
        
        /* 3-byte counter, starting with a random value. */
        $i = $i > 0xFFFFFE ? 1 : $i + 1);
    }
}
