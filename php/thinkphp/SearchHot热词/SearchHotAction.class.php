<?php

/**
 * 专题列表接口
 */
class SearchHotAction extends BaseAction
{
    public function index() {
        $user_id = intval($_POST['user_id']);
        $search_id = D('search_id');
        $result=$search_id->hotword_cache();
        $return = array('data' => $result);
        $this->result(ERR_NONE, $return);
    }
}
