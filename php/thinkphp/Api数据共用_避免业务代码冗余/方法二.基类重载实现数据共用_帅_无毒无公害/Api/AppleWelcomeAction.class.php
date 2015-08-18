<?php

/**
 * 苹果审核专用接口
 */
class AppleWelcomeAction extends BaseAction
{
    public function index() {
        $data = array('title' => 'hello world!', 'time' => time(), 'msg' => '你好,世界!');
        $this->result(ERR_NONE, $data);
    }
}
