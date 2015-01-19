<?php
define('ROOT',__DIR__.'/');
echo '<pre>';

$tmp=dir_list('./app/v2.5/');
if($tmp){
    foreach ($tmp as $value) {
        if(is_file($value)&& fileext($value)=='php'){
            sign($value);
        }
    }
}
echo 'done';
// print_r($tmp);

function sign($filename){
    $txt=file_get_contents($filename);
    $replace="<?php\r\nnamespace to8to\mobileapi;\r\n";
    if(stripos($txt,'<?php')!==false){
        $txt=str_ireplace('<?php',$replace, $txt);
    }else{
        $txt=str_ireplace('<?',$replace, $txt);
    }
    file_put_contents($filename,$txt);
}

function dir_list($path, $exts = '', $list= array()) {
    $path = dir_path($path);
    $files = glob($path.'*');
    foreach($files as $v) {
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

function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if(substr($path, -1) != '/') $path = $path.'/';
    return $path;
}



function fileext($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}