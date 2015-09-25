<?php

/**
 * 优势描述:
 * 它的好处在于home和admin两个分组可以有一些同名类比如index
 * 同时又可以互相调用.不冲突.
 *
 * 如果不使用命名空间,
 * 会导致index这个类只能初始化一次.
 * 第二次再初始化时会失败!
 * 也就是说home\index或admin\index只能有一个实例.
 *
 */

require_once __DIR__ . '/adminindex.php';
require_once __DIR__ . '/homeindex.php';
require_once __DIR__ . '/adminblog.php';

$adminindex = new admin\index();
$adminindex->hello();

$homeindex = new home\index();
$homeindex->hello();

$adminblog = new admin\blog();
$adminblog->hello();
