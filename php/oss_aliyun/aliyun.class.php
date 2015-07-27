<?php

/**
 * 加载sdk包以及错误代码包
 */
require_once __DIR__ . '/sdk.class.php';
// 在conf.inc.php文件里写配置

class aliyun
{
    static $bucket_image = 'zhangchu-image';
    static $bucket_video = 'zhangchu-video';
    
    public static function init() {
        
        // 初始化
        $oss_sdk_service = new ALIOSS(OSS_ACCESS_ID, OSS_ACCESS_KEY, 'oss-cn-shenzhen.aliyuncs.com');
        
        //设置是否打开curl调试模式
        $oss_sdk_service->set_debug_mode(true);
        return $oss_sdk_service;
    }
    
    /**
     * 判断文件是否存在
     * @param  [type]  $file_path [description]
     * @return boolean            [description]
     */
    public static function is_object_exist($file_path) {
        $oss_sdk_service = self::init();
        return $oss_sdk_service->is_object_exist(self::$bucket_image, $file_path);
    }
    
    /**
     * 按路径上传
     * @return [type] [description]
     */
    public static function upload_file_by_file($file_path, $object) {
        $oss_sdk_service = self::init();
        return $oss_sdk_service->upload_file_by_file(self::$bucket_image, $object, $file_path);
    }
}
