<?php

/**
 * 本页面放的是静态接口,仅供演示
 */
class SearchAction extends BaseAction
{
    public function index() {
        $search_id = D('search_id');
        $result=$search_id->hotword_cache(1);
        vlog('crond_select_searchhot', array('status' => 1, 'data' => json_encode($result)), 'cli');
        print_r($result);
        exit;
    }
}
