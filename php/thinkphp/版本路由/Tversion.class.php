<?php

// 接口版本路由
// 功能:每次取最接近的上一个版本进行服务,若无版本取最低版本.
class Tversion
{
    
    // 版本识别
    public static function version_identify($methodName, $version) {
        
        $version_tree = F('API_version_tree');
        if (!$version_tree) {
            $version_tree = self::version_tree();
            
            // 存起来避免重复运算,每次发版以后记得清除路由缓存
            F('API_version_tree', $version_tree);
        }
        
        $return = '';
        if (isset($version_tree[$methodName])) {
            foreach ($version_tree[$methodName] as $filename => $value) {
                if ($version >= $value) {
                    if ($value > 0) define('API_VERSION', $value);
                    $return = $filename;
                    break;
                }
            }
        }
        return $return;
    }
    
    // 版本树
    public static function version_tree() {
        $path = LIB_PATH . 'Action/Api/';
        $files = glob($path . "*Action.class.php");
        $result = array();
        if ($files && count($files)) {
            foreach ($files as $value) {
                $filename = str_ireplace('Action.class.php', '', basename($value));
                $tmp = explode('_', $filename);
                $methodName = array_shift($tmp);
                
                if (count($tmp) >= 2) {
                    $version = strval(array_shift($tmp) . '.' . implode('', $tmp));
                } else {
                    $version = 0;
                }
                $result[$methodName][$filename] = floatval($version);
            }
            
            if ($result && count($result)) {
                foreach ($result as & $value) {
                    arsort($value);
                }
            }
        }
        return $result;
    }
}
