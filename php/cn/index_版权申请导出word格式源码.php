<?php

$files  = dir_list('./x/');
$leng   = 30;
$i      = 0;
$result = '';
if ($files && count($files)) {
    foreach ($files as $key => $value) {
        $result .= "#####" . basename($value) . '#####@start ' . "\r\n";
        $result .= "\r\n\r\n";
        $result .= file_get_contents($value);
        $result .= "\r\n\r\n";
        $result .= "#####" . basename($value) . '#####@end ' . "\r\n";
        $result .= "\r\n\r\n";
        $result .= "\r\n\r\n";
        $i++;
        if ($i >= $leng) {
            break;
        }
    }
}
Header("Content-type:application/vnd.ms-word");
Header("Content-Disposition: attachment;filename=didiyuesao.doc");
echo $result;
exit;

function dir_list($path, $exts = '', $list = array())
{
    $path  = dir_path($path);
    $files = glob($path . '*');
    foreach ($files as $v) {
        $fileext = fileext($v);
        if (!$exts || preg_match("/\.($exts)/i", $v)) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            }
        }
    }
    return $list;
}
function dir_path($path)
{
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/') {
        $path = $path . '/';
    }

    return $path;
}
function fileext($filename)
{
    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}
