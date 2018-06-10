<?php
namespace zhihukeji\api\controller;

use zhihukeji\com\model;

class RoomHallAction extends BaseAction
{

    public function index($p)
    {
        //默认第一页;
        $page = intval($p['page']);
        if ($page < 1) {
            $page = 1;
        }

        //默认每页10条;
        $size = intval($p['size']);
        if (!$size || $size > 20) {
            $size = 20;
        }

        $where = "1";

        if ($p['number']) {
            $number = trim($p['number']);
            $where .= " and ri.number like '%{$number}%'";
        }

        if ($p['room_type'] > 0) {
            $room_type = intval($p['room_type']);
            $where .= ' and ri.room_type=' . $room_type;
        }

        if ($p['status']) {
            $status = intval($p['status']);
            $where .= 'v.status=' . $status;
        }

        $club_id = CLUB_ID;

        $sql = <<<doc
select
ri.id as room_id,ri.number,ri.room_turn,ri.room_area,ri.status as room_status,
ri.room_type,ri.room_style,zro.id as room_order_id,
zrt.name as room_type_name,zrs.name as room_style_name,
sc.start_time,sc.end_time,ui.user_name,
zro.check_in_time,zro.live_in_time,zro.schedule_day,
zro.user_id,sc.status as schedule_status,
v.status as status,
case
when v.status=0 then "空闲"
when v.status=-1 then "维修"
when v.status=1 then "预定"
when v.status=2 then "入住"
end as status_name
from zhihu_room_info ri
left join zhihu_room_order as zro
on ri.id=zro.room_id
left join zhihu_room_type as zrt
on ri.room_type=zrt.id
left join zhihu_room_style as zrs
on ri.room_style=zrs.id
left join zhihu_room_schedule as sc
on zro.schedule_id=sc.id
left join zhihu_user_info as ui
on zro.user_id=ui.id
left join view_room_useable_now as v
on ri.id=v.room_id
where ri.status!=0 and ri.club_id={$club_id} and $where
doc;
        $zhihu_room_info = new model\zhihu_room_info();
        $sql_count       = "select count(*) as count from ($sql)_";
        $tmp             = $zhihu_room_info->query($sql_count);
        $total           = 0;
        if ($tmp && count($tmp)) {
            $total = array_pop(array_pop($tmp));
        }

        $offset   = ($page - 1) * $size;
        $sql_data = "select * from ($sql)_ order by room_id DESC limit {$offset},{$size}";
        $data     = $zhihu_room_info->query($sql_data);

        $count_type = $this->get_type_sumary(); //房型统计

        //状态统计
        $count_status = $this->get_status_sumary();

        $return = array('count_type' => $count_type, 'count_status' => $count_status, 'page' => strval($page), 'size' => strval($size), 'total' => strval($total), 'count' => strval(count($data)), 'data' => $data);
        return array(ERR_NONE, $return);
    }

    /**
     * 获取房型数量-固定
     * @return mixed
     */
    public function get_type_sumary()
    {
        $club_id         = CLUB_ID;
        $room_info_model = new model\zhihu_room_info();
        $sql             = <<<doc
SELECT COUNT(ri.id) AS num,ri.room_type,rt.name AS room_type_name FROM zhihu_room_info AS ri
LEFT JOIN zhihu_room_type AS rt ON ri.room_type=rt.id
WHERE ri.club_id=$club_id AND ri.status !=0  GROUP BY ri.room_type;
doc;
        $result = $room_info_model->query($sql);
        return $result;
    }

    /**
     * 获取房型数量
     * @return mixed
     */
    public function get_status_sumary()
    {
        $club_id         = CLUB_ID;
        $room_info_model = new model\zhihu_room_info();
        $sql             = <<<doc
SELECT count(*) as num,status,
case
when status=0 then "空闲"
when status=-1 then "维修"
when status=1 then "预定"
when status=2 then "入住"
end as room_status_name
from view_room_useable_now group by status
doc;
        $result = $room_info_model->query($sql);
        return $result;
    }

}
