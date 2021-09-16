<?php
define('MODULE_NAME', 'demo_cube');

// 增加个项目名
define('CUBE_MODULE', 'didiyuesao_demo');

define('CUBE_PATH', dirname(dirname(__DIR__)));

$c       = isset($_GET['c']) ? trim($_GET['c']) : '';
$app_dir = __DIR__ . '/app/';
$files   = glob($app_dir . '/*/*.php');
// var_dump($files);exit;
if ($c) {
    // 召唤
    if ($files && count($files)) {
        foreach ($files as $key => $value) {
            if (fmd5($value) == $c && $c) {
                require $value;
                exit;
            }
        }
    }
} else {
    print_r('<h1>Hello didiyuesao Testing!</h1>');
    // 列表
    if ($files && count($files)) {
        foreach ($files as $key => $value) {
            $show = str_ireplace($app_dir, '', $value);
            $link = fmd5($value);
            echo "<a href='http://" . $_SERVER['HTTP_HOST'] . "/deploy/Demo.php?c={$link}' target='_blank'>{$show}</a><br/><br/>";
        }
    }
}

function fmd5($key)
{
    return md5(MODULE_NAME . $key . '2021年9月16日 15:40:38');
}
