<?php

//无论基类或继承类,它的执行过程,都会调用析构函数.

$abcd = new abcd();
$abcd->hello();
exit;

// 结果:
// abc __construct,abcd,abc __destruct,

class abc
{
    function __construct() {
        echo 'abc __construct,';
    }
    function hello() {
        echo 'hello,';
    }
    function __destruct() {
        echo 'abc __destruct,';
    }
}

class abcd extends abc
{
    function hello() {
        echo 'abcd,';
    }
}
