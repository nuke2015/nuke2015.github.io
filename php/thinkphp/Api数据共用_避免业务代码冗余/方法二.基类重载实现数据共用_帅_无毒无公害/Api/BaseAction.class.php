<?php

// 本类由系统自动生成，仅供测试用途
class BaseAction extends CommonAction
{
    
    public function result($code = 0, $data = null, $msg = '') {
        echo ("it's died!");
        echo json_encode($data);
        exit;
    }
}
