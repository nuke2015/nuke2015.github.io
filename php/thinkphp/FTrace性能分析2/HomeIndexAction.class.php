<?php

/**
 * 首页接口
 */
class HomeAction extends BaseAction
{
    public function index() {
        import("@.ORG.FTrace");
        $info=FTrace::info();
        print_r($info);
        exit;
        $this->result(ERR_NONE, $return);
    }
}
