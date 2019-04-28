<?php
/**
 * 使用前要配置
 * OSS_ACCESS_ID和OSS_ACCESS_KEY
 * 
 */

/**
 * 加载sdk包以及错误代码包
 */
require_once __DIR__ . '/sdk.class.php';

class aliyun
{
    static $bucket_image = 'bestphp-pic';
    static $bucket_video = 'bestphp-video';
    static $aliyun_node = 'oss-cn-shenzhen.aliyuncs.com';
    
    public static function init() {
        
        // 初始化
        $oss_sdk_service = new ALIOSS(C('OSS_ACCESS_ID'), C('OSS_ACCESS_KEY'), self::$aliyun_node);
        
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
    
    /**
     * 切片上传
     * @param  [type] $file_path [description]
     * @param  [type] $object    [description]
     * @return [type]            [description]
     */
    public static function upload_by_multi_part_video($file_path, $object) {
        $oss_sdk_service = self::init();
        $options = array(ALIOSS::OSS_FILE_UPLOAD => $file_path, 'partSize' => 5242880,);
        return $oss_sdk_service->create_mpu_object(self::$bucket_video, $object, $options);
    }
}
