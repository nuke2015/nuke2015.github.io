<?php
Class ClassA
{
    function __construct() {
        echo "ClassA __construct,";
    }
    static function bc($b, $c) {
        $bc = $b + $c;
        echo $bc;
    }
    function __destruct() {
        echo "classa __destruct,";
    }
}

call_user_func_array(array('ClassA', 'bc'), array("111", "222"));
exit;

// 若类方法bc非静态会报错
// Strict Standards: call_user_func_array() expects parameter 1 to be a valid callback, non-static method ClassA::bc() should not be called statically in D:\wt-nmp\WWW\vhost1\index.php on line 15

// 若类方法bc为静态则正常,说明call_user_func_array用的是静态调用,
// 那么构造函数和析构函数都有可能没执行.
