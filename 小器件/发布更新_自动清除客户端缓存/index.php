<?php
require 'Fdir.class.php';

echo '<pre>';
$dir  = './html';
$data = Fdir::dir_list($dir);
if ($data && count($data)) {
    foreach ($data as $key => $value) {
        $txt        = file_get_contents($value);
        $txt        = update($txt);
        $value_done = str_replace($dir, './done', $value);
        file_put_contents($value_done, $txt);
    }
}
echo 'done!';
exit;

// 更新缓存
function update($txt)
{
    update_js($txt);
    update_css($txt);
    return $txt;
}

// 日志
function vlog($file, $data)
{
    $txt = json_encode($data) . "\r\n";
    file_put_contents($file, $txt, FILE_APPEND);
}

// 更新脚本
function update_js(&$txt)
{
    preg_match_all('@/js(.*)\.js@U', $txt, $js);
    $result = array();
    if ($js && count($js)) {
        // 取全量组
        foreach ($js[0] as $key => $value) {
            $value_to = $value . '?v=' . time();
            $txt      = str_replace($value, $value_to, $txt);
            $result[] = array('from' => $value, 'to' => $value_to);
        }
    }
    vlog('js.log', $result);
}

// 更新样式文件
function update_css(&$txt)
{
    preg_match_all('@/css(.*)\.css@U', $txt, $css);
    $result = array();
    if ($css && count($css)) {
        // 取全量组
        foreach ($css[0] as $key => $value) {
            $value_to = $value . '?v=' . time();
            $txt      = str_replace($value, $value_to, $txt);
            $result[] = array('from' => $value, 'to' => $value_to);
        }
    }
    print_r($result);
    vlog('css.log', $result);
}
