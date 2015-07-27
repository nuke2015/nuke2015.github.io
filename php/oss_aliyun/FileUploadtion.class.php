<?php

/**
 * 仅供快速测试
 */
class FileUploadAction extends BaseAction
{
    
    /**
     * 用户头像上传
     * @return [type] [description]
     */
    private function upload_file() {
        $file = $_FILES['file'];
        require_once APP_PATH . 'Lib/ORG/oss_php_sdk/aliyun.class.php';
        
        //有文件,并且5M以内
        if (count($file) && $file['size'] > 0 && $file['size'] < 5000000) {
            
            // 文件真实大小
            $real_size = getimagesize($file['tmp_name']);
            if (!$real_size || $real_size < 4) {
                system_log('file upload fail#realsize', $realsize);
                $this->result(ERR_FILEUPLOAD);
            }
            
            //去掉gbk编码
            $file_name = auto_charset($file['name']);
            $file_name = strtolower($file_name);
            
            //扩展名判断
            $file_name_ext = end(explode('.', $file_name));
            if (!in_array($file_name_ext, array('jpg', 'gif', 'jpeg', 'bmp'))) {
                system_log('file upload fail#extsion_name', $file_name_ext);
                $this->result(ERR_FILEUPLOAD);
            }
            
            $file_name = str_ireplace('.' . $file_name_ext, '', $file_name);
            $file_name.= '_' . time();
            import("@.ORG.String");
            $file_save_name = $file_name . String::rand_string(10, 1);
            $file_save_name.= "." . $file_name_ext;
            
            //判断文件是否存在
            $resp = aliyun::is_object_exist($file_save_name);
            
            //重新取扩展名
            if ($resp->status == 200) {
                $file_save_name = $file_name . String::rand_string(10, 1);
                $file_save_name.= "." . $file_name_ext;
            }
            $resp = aliyun::upload_file_by_file($file['tmp_name'], $file_save_name);
            if ($resp->status == 200) {
                return $file_save_name;
            } else {
                system_log('file upload fail#upload_file_by_file', $_FILES);
                $this->result(ERR_FILEUPLOAD);
            }
        } else {
            system_log('file upload fail#size', $_FILES);
            $this->result(ERR_FILEUPLOAD);
        }
    }
}
