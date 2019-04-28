<?php

/**
 * 本页面放的是静态接口,仅供演示
 */
class IndexAction extends BaseAction
{

    public function index()
    {
        // $this->service('siyoucang','huangmayehaizaonongtangA.mp4');
        // exit;
    }

    // 开始服务
    private function service($bucket, $object)
    {

        $meta = $this->get_meta($bucket, $object);
        if ($meta->status == 200) {

            $type = $meta->header['content-type'];
            $size = $meta->header['content-length'];
            header("Content-type: {$type}");
            header("Content-Length:{$size}");

            // $_SERVER['HTTP_RANGE'] = 'bytes 0-720507/720508';
            if (isset($_SERVER['HTTP_RANGE'])) {
                $this->readfile_range($bucket, $object, $size);
            } else {
                $this->readfile_all($bucket, $object);
            }
        } else {
            send_http_status(404);
        }
        exit;
    }

    // 取信息
    private function get_meta($bucket, $object, $size)
    {
        import("@.ORG.oss_php_sdk.aliyun_oss_hangzhou");
        $meta = aliyun_oss_hangzhou::get_object_meta($bucket, $object, $option);
        return $meta;
    }

    // 流媒体
    private function readfile_range($bucket, $object, $size)
    {

        // 下游分析
        $ranges = $this->get_range();

        // If the last range param is empty, it means the EOF (End of File)
        if (!$ranges[1]) {
            $ranges[1] = $size - 1;
        }
        // Send the appropriate headers
        header('HTTP/1.1 206 Partial Content');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . ($ranges[1] - $ranges[0]));
        header(sprintf('Content-Range: bytes %d-%d/%d', $ranges[0], $ranges[1], $size));

        import("@.ORG.oss_php_sdk.aliyun_oss_hangzhou");
        $option = array();
        $option = array('range' => $range[0] . '-' . $range[1]);
        $data   = aliyun_oss_hangzhou::get_object($bucket, $object, $option);
        echo $data->body;
        exit;
    }

    //全文下载
    private function readfile_all($bucket, $object)
    {
        import("@.ORG.oss_php_sdk.aliyun_oss_hangzhou");
        $aliyun_sign_url = aliyun_oss_hangzhou::get_sign_url($bucket, $object);
        echo readfile($aliyun_sign_url);
        exit;
    }

    // 取头部
    private function get_range($file, $size)
    {
        $ranges = array_map(
            'intval', // Parse the parts into integer
            explode(
                '-', // The range separator
                substr($_SERVER['HTTP_RANGE'], 6) // Skip the `bytes=` part of the header
            )
        );
        return $ranges;
    }

}
