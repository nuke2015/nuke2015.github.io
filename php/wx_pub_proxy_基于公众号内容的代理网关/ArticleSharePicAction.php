<?php

namespace jiazhenpt\home\controller;

use didiyuesao\com\org;

// 文章内的图片的代理
class ArticleSharePicAction extends ArticleShareInfoAction
{
    public function index($p)
    {
        $key = isafe($p['key']);
        if ($key) {
            $file = RUNTIME_PATH . "/jiazhen_share_image/{$key}";
            if (!file_exists($file)) {
                $Tfilecache = $this->datastore();
                $url_refer  = $Tfilecache::get($key);
                if ($url_refer) {
                    // 流同步
                    org\Fio::stream_to_stream($url_refer, $file);
                }
            }
            echo readfile($file);
            exit;
        }
        return [ERR_WRONG_ARG, 'key empty'];
    }
}
