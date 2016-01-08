<?php

// // 测试用例
// // $tmp=fdir::dir_list('./');
// // $tmp=fdir::dir_tree('./');
// // $tmp=fdir::fileext('index.php');
// // $tmp=fdir::dir_path('./');
// // $tmp=fdir::dir_create('./abc/abc');
// // $tmp=fdir::mk_dir('./abc/abd');
// // $tmp=fdir::dir_copy('./abc/abd','./abd/abc');
// $tmp = fdir::dir_delete('./abd/abc');
// print_r($tmp);

class Fdir {
    
    //扩展名
    public static function fileext($filename) {
        return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
    }
    
    //上级路径
    public static function dir_path($path) {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }
    
    //创建目录
    public static function dir_create($path, $mode = 0777) {
        if (is_dir($path)) return TRUE;
        $ftp_enable = 0;
        $path = self::dir_path($path);
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for ($i = 0;$i < $max;$i++) {
            $cur_dir.= $temp[$i] . '/';
            if (@is_dir($cur_dir)) continue;
            @mkdir($cur_dir, 0777, true);
            @chmod($cur_dir, 0777);
        }
        return is_dir($path);
    }
    
    // 单一建目录
    public static function mk_dir($dir, $mode = 0777) {
        if (is_dir($dir) || @mkdir($dir, $mode)) return true;
        if (!mk_dir(dirname($dir), $mode)) return false;
        return @mkdir($dir, $mode);
    }
    
    // 目录复制
    public static function dir_copy($fromdir, $todir) {
        $fromdir = self::dir_path($fromdir);
        $todir = self::dir_path($todir);
        if (!is_dir($fromdir)) return FALSE;
        if (!is_dir($todir)) self::dir_create($todir);
        $list = glob($fromdir . '*');
        if (!empty($list)) {
            foreach ($list as $v) {
                $path = $todir . basename($v);
                if (is_dir($v)) {
                    self::dir_copy($v, $path);
                } 
                else {
                    copy($v, $path);
                    @chmod($path, 0777);
                }
            }
        }
        return TRUE;
    }
    
    //文件列表
    public static function dir_list($path, $exts = '', $list = array()) {
        $path = self::dir_path($path);
        $files = glob($path . '*');
        foreach ($files as $v) {
            $fileext = self::fileext($v);
            if (!$exts || preg_match("/\.($exts)/i", $v)) {
                $list[] = $v;
                if (is_dir($v)) {
                    $list = self::dir_list($v, $exts, $list);
                }
            }
        }
        return $list;
    }
    
    //目录树加id
    public static function dir_tree($dir, $parentid = 0, $dirs = array()) {
        if ($parentid == 0) {
            $id = 0;
        } 
        else {
            $id = $parentid;
        }
        $list = glob($dir . '*');
        foreach ($list as $v) {
            if (is_dir($v)) {
                $id++;
                $dirs[$id] = array('id' => $id, 'parentid' => $parentid, 'name' => basename($v), 'dir' => $v . '/');
                $dirs = self::dir_tree($v . '/', $id, $dirs);
            }
        }
        return $dirs;
    }
    
    //目录删除
    public static function dir_delete($dir) {
        $dir = self::dir_path($dir);
        if (!is_dir($dir)) return FALSE;
        $list = glob($dir . '*');
        foreach ((array)$list as $v) {
            is_dir($v) ? self::dir_delete($v) : @unlink($v);
        }
        return @rmdir($dir);
    }
}
