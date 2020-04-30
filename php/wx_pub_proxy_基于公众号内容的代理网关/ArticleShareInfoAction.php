<?php

namespace jiazhenpt\home\controller;

use didiyuesao\com\base;
use didiyuesao\com\org;
use jiazhenpt\api_muying\controller as api_muying;

// 文章分享,提取,访问速度超级快
// http://localhost/home/ArticleShareInfo?id=10&member_id=1
class ArticleShareInfoAction extends BaseAction
{
    public function index($p)
    {
        $id        = intval($p['id']);
        $member_id = intval($p['member_id']);
        if (!$id || !$member_id) {
            exit('member_id');
        }

        $html                   = '';
        $ArticleShareInfoAction = new api_muying\ArticleShareInfoAction();
        list($err, $data)       = $ArticleShareInfoAction->index($p);
        if ($data['url_refer']) {
            $key        = 'html_articleshare_' . $member_id . $id;
            $Tfilestore = $this->datastore();
            if (!$html) {
                $html = $this->curl_web($data['url_refer'], $p);
                if ($html) {
                    $Tfilestore::set($key, $html);
                }
            }
            $html = $Tfilestore::get($key);
        }
        return [200, $html];
    }

    // 采集
    public function curl_web($url_refer, $p)
    {
        $data = org\myhttp::curl($url_refer);
        if ($data) {
            // $data = str_ireplace('<head>', "<head><base href='{$url_refer}' /><meta name='referrer' content='never'>", $data);
            $data = str_ireplace('<head>', "<head><meta name='referrer' content='never' />", $data);
            $data = $this->replace_image($data, $p);
        }
        return $data;
    }

    private function replace_image($data, $p)
    {
        preg_match_all('@"https://mmbiz.qpic.cn(.*)"@isU', $data, $imgs);
        if ($imgs && count($imgs)) {
            $host       = 'https://mmbiz.qpic.cn';
            $id         = intval($p['id']);
            $member_id  = intval($p['member_id']);
            $tag        = $member_id . '_' . $id;
            $result     = [];
            $Tfilecache = $this->datastore();
            foreach ($imgs[1] as $key => $value) {
                $value = $host . $value;
                $key   = $member_id . '_' . $id . '_' . md5($value);
                $Tfilecache::set($key, $value);
                $host_pic = "/home/ArticleSharePic?key={$key}";
                // 缓存
                $data = str_ireplace($value, $host_pic, $data);
            }
        }
        return $data;
    }

    protected function datastore()
    {
        $Tfilestore             = new base\Tfilestore();
        $Tfilestore::$dir_store = RUNTIME_PATH . '/jiazhen_share_html';
        return $Tfilestore;
    }
}
