<?php

use app\common\org;

// 模板辅助类召唤
if (!function_exists('msubstr')) {
    // 比如字符截短
    // {:org_string()->msubstr('你好世界',2,25);}
    function org_string()
    {
        $String = new org\String();
        return $String;
    }
}
