<?php
namespace app\common\model;

class ddys_comment_image extends BaseModel
{
    protected $table = 'ddys_comment_image';

    // 取全部
    public function get_all($where, $field, $order = 'order_no DESC')
    {
        return $this->table()->where($where)->field($field)->order($order)->select();
    }

    // 月嫂风采
    public function fengcai_select($yuesao_id, $offset, $length = 10)
    {
        $where = "dcy.yuesao_id={$yuesao_id}";
        $sql   = "select dci.image,dcy.create_at as create_at from ddys_comment_yuesao as dcy right join ddys_comment_image as dci on dcy.id=dci.comment_id where {$where} order by dcy.id DESC limit {$offset},{$length}";
        return $this->query($sql);
    }

    // 计数
    public function fengcai_count($yuesao_id)
    {
        $where = "dcy.yuesao_id={$yuesao_id}";
        $sql   = "select count(1) as count from ddys_comment_yuesao as dcy right join ddys_comment_image as dci on dcy.id=dci.comment_id where {$where} order by dcy.id DESC";
        $data  = $this->query($sql);
        $count = 0;
        if ($data && count($data)) {
            $count = $data[0]['count'];
        }
        return $count;
    }
}
