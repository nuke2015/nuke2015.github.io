<?php
namespace app\api\controller;

use app\common\model;
use app\common\org;

// 月嫂列表页
class YuesaoShowListAction
{

    public function index()
    {

        $p = org\input::xss($_POST);

        $yuesao_id = intval($p['yuesao_id']);
        if (!$yuesao_id) {
            return array(ERR_WRONG_ARG, 'yuesao_id');
        }

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

        // 此处使用了原生的sql,查询,所以不能用正常的page分页
        $ddys_comment_image = new model\ddys_comment_image();
        $total              = $ddys_comment_image->fengcai_count($yuesao_id);

        $Page_helper = new org\Page($total, $size, $page);
        $result      = $ddys_comment_image->fengcai_select($yuesao_id, $Page_helper->firstRow, $Page_helper->listRows);

        $return = array('page' => strval($page), 'size' => strval($size), 'total' => strval($total), 'count' => strval(count($result)), 'data' => $result);

        return array(ERR_NONE, $return);
    }
}
