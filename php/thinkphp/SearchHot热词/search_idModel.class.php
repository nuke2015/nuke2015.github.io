<?php
class search_idModel extends Model
{
    public $trueTableName = 'search_id';
    
    //搜索热词
    public function hotword() {
        $table_search_id = $this->trueTableName;
        $where = '1';
        $field = 'search_id,search_content,count(user_id)';
        $group = 'search_content';
        $order = 'count(user_id) desc';
        $limit = '0,5';
        $info = $this->where($where)->field($field)->group($group)->order($order)->limit($limit)->select();
        return $info;
    }
    
    //无数据时动态生成,异步更新
    public function hotword_cache($force_update) {
        $diffkey = "search_idModel#hotword_cache";
        $result = redisModel::get($diffkey);
        if (!$result || $force_update) {
            $list = $this->hotword();
            $result = array();
            if (count($list)) {
                foreach ($list as $value) {
                    $result[] = array('id' => $value['search_id'], 'text' => $value['search_content']);
                }
            }
            redisModel::set($diffkey, $result, 3600);
        }
        return $result;
    }
}
