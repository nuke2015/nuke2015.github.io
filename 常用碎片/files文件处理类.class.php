<?php

// 测试用例
// include __DIR__ . '/files.class.php';
// $dirs = files::dirs_tree('./doc');
// print_r($dirs);
// $files = files::files_tree('./doc');
// print_r($files);
// $files_php = files::files_tree('./doc', '.tpl');
// print_r($files_php);
// exit;



/**
 * 文件处理相关类
 * 锋子 it07@qq.com
 * 2015年8月16日 17:46:47
 */
class files
{
    
    /**
     * 文件树
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public static function files_tree($path, $file_extension = '') {
        $list = glob($path . '/*');
        $result = array();
        if (count($list)) {
            foreach ($list as $value) {
                if (is_dir($value)) {
                    $result = array_merge($result, self::files_tree($value, $file_extension));
                } 
                else {
                    
                    //目标类型过滤;
                    if ($file_extension && (self::file_ext($value) != $file_extension)) continue;
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
    
    /**
     * 目录树
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public static function dirs_tree($path) {
        $list = glob($path . '/*');
        $result = array();
        if (count($list)) {
            foreach ($list as $value) {
                if (is_dir($value)) {
                    $result[] = $value . '/';
                    $result = array_merge($result, self::dirs_tree($value));
                }
            }
        }
        return $result;
    }
    
    /**
     * 扩展名
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public static function file_ext($filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $extension = strtolower('.' . $extension);
        return $extension;
    }
    
    /**
     * 大文本分片读取
     * 作用类似于,数组切片.
     * 注意释放资源,不用file($filename)数组;
     * 此处直接返回单行文本内容不拆分,
     * 而在业务消费处把文本拆分成数组,
     * 有利于当前函数功能复用.
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    public static function slice($filename, $offset, $length) {
        $result = array();
        $fp = fopen($filename, "r");
        while (!feof($fp)) {
            $i++;
            $line = fgets($fp);
            if ($i < $offset) continue;
            $result[] = trim($line);
            if ($i >= $offset + $length) break;
        }
        fclose($fp);
        return $result;
    }
}
