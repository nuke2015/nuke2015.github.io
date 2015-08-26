<?php

//引入包含文件
require_once (__DIR__ . "/CloudsearchClient.php");
require_once (__DIR__ . "/CloudsearchIndex.php");
require_once (__DIR__ . "/CloudsearchDoc.php");
require_once (__DIR__ . "/CloudsearchSearch.php");
require_once (__DIR__ . "/CloudsearchSuggest.php");

class opensearch
{
    
    const HOST = 'http://opensearch-cn-qingdao.aliyuncs.com';
    const KEY_TYPE = 'aliyun';
    public static $client;
    public static $app_name = 'kitchen';
    
    //连接句柄
    public static function client_init() {
        if (!self::$client) {
            $OSS_ACCESS_ID = C('OSS_ACCESS_ID');
            $OSS_ACCESS_KEY = C('OSS_ACCESS_KEY');
            $opts = array('host' => self::HOST);
            self::$client = new CloudsearchClient($OSS_ACCESS_ID, $OSS_ACCESS_KEY, $opts, self::KEY_TYPE);
        }
        
        //初始化失败
        if (!self::$client) halt('the aliyun opensearch has gone away!');
        return self::$client;
    }
    
    /**
     * 全文搜索
     * @return [type] [description]
     */
    public static function search_query($query, $page = 1, $size = 10) {
        $client = self::client_init();
        $search_obj = new CloudsearchSearch($client);
        $search_obj->addIndex(self::$app_name);
        $search_obj->setQueryString($query);
        
        //页码修复
        if ($page < 1) $page = 1;
        $search_obj->setStartHit(($page - 1) * $size);
        $search_obj->setHits($size);
        $search_obj->setFormat('json');
        try {
            $json = $search_obj->search();
        }
        catch(Exception $e) {
        }
        return $json;
    }
    
    /**
     * 下拉提示查询接口
     * @param  string $suggest_name [description]
     * @param  [type] $query        [description]
     * @param  [type] $page         [description]
     * @param  [type] $size         [description]
     * @return [type]               [description]
     */
    public static function suggest_query($suggest_name = 'dishes_name', $query, $size = 10) {
        $client = self::client_init();
        $suggest = new CloudsearchSuggest($client);
        $suggest->setIndexName(self::$app_name);
        $suggest->setSuggestName($suggest_name);
        $suggest->setHits($size);
        $suggest->setQuery($query);
        try {
            $json = $suggest->search();
        }
        catch(Exception $e) {
        }
        return $json;
    }
}
