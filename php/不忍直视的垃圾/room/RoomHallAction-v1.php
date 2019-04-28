<?php
namespace zhihukeji\api\controller;

use zhihukeji\com\model;

/**
 * 房态大厅
 * Class RoomHallAction
 * @package zhihukeji\api\controller
 */
class RoomHallAction extends RbacNodeTreeAction
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

        $where = array();

        if (!empty($p['number'])) {
            $where['ri.number'] = intval($p['number']);
        }

        if (!empty($p['room_type'])) {
            $where['ri.room_type'] = intval($p['room_type']);
        }

        //状态 0空闲 1预定 2入住 -1维修

        if (is_numeric($p['status'])) {
            $status = intval($p['status']);
            if ($status == -1) {
                $where['ri.status'] = -1;
            } else {
                if($status ==1){
                    $where['rsc.status'] = 1;
                }elseif($status ==2){
                    $where['rsc.status'] = 2;
                }else{
                    $where['ri.status !'] = -1;
                }
            }
        }


        list($list, $total) = $this->get_page_list($where, $page, $size ,$status);

        //$count_type         = $this->get_type_count_fixed();//房型统计
        $count_type         = $this->get_type_count($list);//房型统计
        if($count_type[0]['num'] > $size){
            $count_type[0]['num'] = 20;
        }

        //状态统计
        $count_status       = $this->get_status_count($list);

        $return = array('count_type' => $count_type,'count_status' => $count_status, 'page' => strval($page), 'size' => strval($size), 'total' => strval($total), 'count' => strval(count($list)), 'data' => $list);
        return array(ERR_NONE, $return);
    }


    /**
     * 获取房态大厅相关信息列表
     * @param $page
     * @param $size
     * @return mixed
     * $sql = 'select ri.number,ri.status AS room_info_status from zhihu_room_info AS ri LEFT JOIN  zhihu_room_order AS ro ON ri.id=ro.room_id !=0  LEFT JOIN zhihu_room_schedule AS rs ON ro.schedule_id=rs.id  WHERE  ri.club_id='.CLUB_ID;

     */
    public function get_page_list($where, $page, $size ,$status)
    {
        $club_id = CLUB_ID;
        $time = time();
        if(is_array($where) && !empty($where)){
            $i = 0;
            foreach ($where as $k=>$v){
                if($i){
                    $where .= ' and '.$k.'='.$v;
                }else{
                    $where = ' where '.$k.'='.$v;
                }
                $i++;
            }
        }else{
            $where = ' WHERE 1';
        }

        $room_info_model = new model\zhihu_room_info();

        $sql = <<<doc
        SELECT COUNT(*) AS count FROM (
SELECT ri.id as room_id,ri.number,ri.room_turn,ri.room_area,ri.status as room_status,ri.admin_id,rt.name as room_type_name,rs.name as room_style_name,
ri.room_type,ri.room_style,'' as order_id, '' as user_name ,'' as check_in_time,'' as live_in_time,'' as schedule_day,'' as user_id,'' as schedule_status
FROM zhihu_room_info AS ri 
LEFT JOIN zhihu_room_type AS rt ON rt.id=ri.room_type
LEFT JOIN zhihu_room_style  AS rs ON rs.id=ri.room_style
LEFT JOIN zhihu_room_schedule AS rsc ON rsc.room_id=ri.id
$where AND ri.status !=0 AND ri.club_id=$club_id AND ($time<rsc.start_time OR $time>rsc.end_time OR ri.id not in(SELECT room_id FROM zhihu_room_schedule))

union 

SELECT ri.id as room_id,ri.number,ri.room_turn,ri.room_area,ri.status as room_status,ri.admin_id,rt.name as room_type_name,rs.name as room_style_name,
ri.room_type,ri.room_style,ro.order_id,ui.user_name,ro.check_in_time,ro.live_in_time,ro.schedule_day,ui.id as user_id,rsc.status as schedule_status
FROM zhihu_room_info AS ri 
LEFT JOIN zhihu_room_type AS rt ON rt.id=ri.room_type
LEFT JOIN zhihu_room_style  AS rs ON rs.id=ri.room_style
LEFT JOIN zhihu_room_schedule AS rsc ON rsc.room_id=ri.id
LEFT JOIN zhihu_room_order AS ro ON ro.schedule_id=rsc.id
LEFT JOIN zhihu_user_info AS ui ON ui.id=ro.user_id
$where AND ri.status !=0 AND ri.club_id=$club_id AND $time>rsc.start_time AND $time<rsc.end_time
) AS tmp
doc;
        $total = $room_info_model->query($sql);
        $total = $total[0]['count'];
        
        $offset = ($page-1)*$size;
        $sql = <<<doc
        SELECT * FROM (
SELECT ri.id as room_id,ri.number,ri.room_turn,ri.room_area,ri.status as room_status,ri.admin_id,rt.name as room_type_name,rs.name as room_style_name,
ri.room_type,ri.room_style,'' as order_id, ''as start_time,''as end_time,'' as user_name ,'' as check_in_time,'' as live_in_time,'' as schedule_day,'' as user_id,'' as schedule_status,rsc.status as need_status
FROM zhihu_room_info AS ri 
LEFT JOIN zhihu_room_type AS rt ON rt.id=ri.room_type
LEFT JOIN zhihu_room_style  AS rs ON rs.id=ri.room_style
LEFT JOIN zhihu_room_schedule AS rsc ON rsc.room_id=ri.id
$where AND ri.status !=0 AND ri.club_id=$club_id AND ($time<rsc.start_time OR $time>rsc.end_time OR ri.id not in(SELECT room_id FROM zhihu_room_schedule))

union 

SELECT ri.id as room_id,ri.number,ri.room_turn,ri.room_area,ri.status as room_status,ri.admin_id,rt.name as room_type_name,rs.name as room_style_name,
ri.room_type,ri.room_style,ro.order_id,rsc.start_time,rsc.end_time,ui.user_name,ro.check_in_time,ro.live_in_time,ro.schedule_day,ui.id as user_id,rsc.status as schedule_status,rsc.status as need_status
FROM zhihu_room_info AS ri 
LEFT JOIN zhihu_room_type AS rt ON rt.id=ri.room_type
LEFT JOIN zhihu_room_style  AS rs ON rs.id=ri.room_style
LEFT JOIN zhihu_room_schedule AS rsc ON rsc.room_id=ri.id
LEFT JOIN zhihu_room_order AS ro ON ro.schedule_id=rsc.id
LEFT JOIN zhihu_user_info AS ui ON ui.id=ro.user_id
$where AND ri.status !=0 AND ri.club_id=$club_id AND $time>rsc.start_time AND $time<rsc.end_time
) AS tmp
LIMIT $offset,$size
doc;

        $list = $room_info_model->query($sql);
        if(!$list){
            return [array(), 0];
        }

        $time = time();
        foreach ($list as $key=>&$info) {
            if($status == 1 || $status == 2){
                if(($info['need_status']==1 && !$info['user_id']) || ($info['need_status']==2 && !$info['user_id'])){
                    unset($list[$key]);
                    continue;
                }
            }

            if(is_numeric($status)&& $status == 0){
                if($info['schedule_status'] == 1 || $info['schedule_status'] == 2){
                    unset($list[$key]);
                    continue;
                }
            }

            $info['status'] = 0;
            $info['status_name'] = '空闲';
            $info['surplus_day'] = '';//剩余天数
            $info['leave_room_time'] = '';//退房时间
            if ($info['room_status'] == -1) {
                $info['status'] = -1;
                $info['status_name'] = '维修中';
            } else {
                if ($info['schedule_status'] == 1) {
                    $info['status'] = 1;
                    $info['status_name'] = '预定';
                    $start = strtotime(date("Ymd", $time));
                    $end = strtotime(date("Ymd", $info['check_in_time']));
                    $info['surplus_day'] = ceil(($end - $start) / (3600 * 24)); //剩余天数
                    if ($info['surplus_day'] < 0) {
                        $info['surplus_day'] = 0;
                    }
                } elseif ($info['schedule_status'] == 2) {
                    $info['status'] = 2;
                    $info['status_name'] = '入住';
                    $start = strtotime(date("Ymd", $time));
                    $end = strtotime(date("Ymd", $info['live_in_time'])) + ($info['schedule_day'] * 3600 * 24);
                    $info['surplus_day'] = ceil(($end - $start) / (3600 * 24)); //剩余天数
                    $info['leave_room_time'] = $end; //退房时间
                    if ($info['surplus_day'] < 0) {
                        $info['surplus_day'] = 0;
                    }
                }
            }
        }
        unset($info);
        //房间处理
        $result = $this->deal_room($list);
        //排序
        $result = \zhihukeji\com\org\ZArray::sortArrByManyField($result,'id','SORT_DESC');

        return [$result, $total];
    }

    //去重
    public function deal_room($arr=array()){
        $newarr = array();
        foreach ($arr as $key=>$val){
            $newarr[$val['room_id']] = $val;
        }
        return $newarr;
    }

    /**
     * 获取房型数量-动态改变
     * @return mixed
     */
    public function get_type_count($arr=array())
    {
        $newarr = array();

        foreach ($arr as $key=>$val){
            if(!isset($newarr[$val['room_type']])){
                $newarr[$val['room_type']] = array('room_type'=>$val['room_type'],'room_type_name'=>$val['room_type_name']);
                $newarr[$val['room_type']]['num'] = 1;
            }else{
                $newarr[$val['room_type']]['num']++;
            }
        }

        $type_fixed = $this->get_type_count_fixed();
        if(!$type_fixed || !$newarr){
            return array();
        }

        $num = 0;
        foreach ($type_fixed as &$fixed){
            $num += $fixed['num'];
            foreach ($newarr as $val){
                if($fixed['room_type'] == $val['room_type']){
                    $fixed['num'] = $val['num'];
                }
            }
        }
        unset($fixed);
        $type_fixed[] = array(
            'room_type' => 0,
            'room_type_name' => '全部',
            'num' => $num,
        );
        array_unshift($type_fixed, array_pop($type_fixed));

        return $type_fixed;
    }

    /**
     * 获取房型数量-固定
     * @return mixed
     */
    public function get_type_count_fixed()
    {
        $club_id         = CLUB_ID;
        $room_info_model = new model\zhihu_room_info();
        $sql             = <<<doc
SELECT COUNT(ri.id) AS num,ri.room_type,rt.name AS room_type_name FROM zhihu_room_info AS ri
LEFT JOIN zhihu_room_type AS rt ON ri.room_type=rt.id
WHERE ri.club_id=$club_id AND ri.status !=0  GROUP BY ri.room_type;
doc;
        $result = $room_info_model->query($sql);
        /*$sql             = <<<doc
SELECT COUNT(ri.id) AS count FROM zhihu_room_info AS ri
LEFT JOIN zhihu_room_type AS rt ON ri.room_type=rt.id
WHERE ri.club_id=$club_id AND ri.status !=0 ;
doc;
        $res = $room_info_model->query($sql);
        $count = $res[0]['count'];
        $result[] = array(
            'num' => $count,
            'room_type' => 0,
            'room_type_name' => '全部',
        );
        array_unshift($result, array_pop($result));*/

        return $result;
    }


    /**
     * 获取房型数量
     * @return mixed
     */
    public function get_status_count($data)
    {
        $arr = array();
        $num0 = 0;
        $num1 = 0;
        $num2 = 0;
        $num3 = 0;
        foreach ($data as $val){
            if($val['status'] == 0){
                $num0 ++;
            }
            if($val['status'] == 1){
                $num1 ++;
            }
            if($val['status'] == 2){
                $num2 ++;
            }
            if($val['status'] == -1){
                $num3 ++;
            }
        }
        $arr[0] = array('num'=>$num0,'status'=>0,'status_name'=>'空闲');
        $arr[1] = array('num'=>$num1,'status'=>1,'status_name'=>'已预约');
        $arr[2] = array('num'=>$num2,'status'=>2,'status_name'=>'已入住');
        $arr[3] = array('num'=>$num3,'status'=>-1,'status_name'=>'维修中');

        return $arr;
    }

}
