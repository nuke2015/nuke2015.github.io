<?php

/**
 * 本页面放的是静态接口,仅供演示
 */
class TestAction extends BaseAction
{
    public function index() {
        $search_id = D('search_id');
        $result=$search_id->hotword_cache();
        vlog('crond_select_searchhot', array('status' => 1, 'data' => $result), 'cli');
        print_r($result);
        exit;
    }
}
