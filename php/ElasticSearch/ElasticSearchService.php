<?php
namespace app\common\service;

use app\common\org;
use think\Config;

// 全文搜索服务
class ElasticSearchService extends BaseService
{
    // 家家资讯
    const URL_ARTICLE = '/jiajiayuesao/article';

    // 添加索引
    public function index_add($url, $id, $data)
    {
        $url .= "/$id";
        $return = self::xget($url, $data);
        return $return;
    }

    // 搜索
    public function search_filter($url, $filter, $from = 0, $size = 20, $sort = array())
    {
        $url .= '/_search';
        $json = array(
            'filter' => $filter,
            'from'   => $from,
            'size'   => $size,
        );
        if ($sort && count($sort)) {
            $json['sort'] = $sort;
        }
        $return = self::xget($url, $json);
        if ($return && count($return)) {
            $return = $return['hits'];
        }
        return $return;
    }

    // {
    //     "query":{
    //         "match":{
    //             "content":{
    //                 "query":"我的宝马多少马力"
    //             }
    //         }
    //     }
    // }
    public function query($url, $query, $from = 0, $size = 20, $sort = array())
    {
        $query = array('query' => $query, 'from' => $from, 'size' => $size);
        // 增加排序控制
        if ($sort && count($sort)) {
            $query['sort'] = $sort;
        }
        $url .= '/_search';
        $return = self::xget($url, $query);
        if ($return && count($return)) {
            $return = $return['hits'];
        }
        return $return;
    }

    // 查询
    public function search_all($url, $from = 0, $size = 20)
    {
        $json = array(
            'query' => array('match_all' => []),
            'from'  => $from,
            'size'  => $size,
        );
        // 搜索入口
        $url .= '/_search';
        $return = self::xget($url, $json);
        if ($return && count($return)) {
            $return = $return['hits'];
        }
        return $return;
    }

    // curl -XGET 'http://192.168.1.248:9200/hello/world/_search?pretty' -d '{
    //     "query": {
    //         "match_all": {}
    //     },
    //     "from": 0,
    //     "size": 100
    // }'
    // 直接查询
    public function xget($url, $data)
    {
        $config_elasticsearch = Config::get('elasticsearch');
        if (!$config_elasticsearch) {
            die('elasticsearch server pls!');
        }

        // 此处的url做环境区分因为index与_search不同.
        $url  = $config_elasticsearch['host'] . $url . '?';
        $resp = org\myhttp::postfield($url, json_encode($data, 1), array(), array(CURLOPT_USERPWD => $config_elasticsearch['username'] . ':' . $config_elasticsearch['password']));

        // 增加日志,一般关闭否则会很大,这是基础服务
        self::log('ElasticSearchService_min', [$url, 'req' => $data]);
        // self::log('ElasticSearchService', [$url, 'req' => $data, 'resp' => $resp]);

        $return = array();
        if ($resp) {
            $return = json_decode($resp, 1);
        }
        return $return;
    }
}

// 添加索引
// $data = array('a' => 'value2_' . time());
// $d    = service\ElasticSearchService::index_add('/hello/world', time(), $data);
// var_dump($d);
// exit;

// 测试
// $d = service\ElasticSearchService::search_all('/hello/world');
// var_dump($d);
// exit;

// 测试过滤
// $filter = array('and' => array('filters' => [array('term' => array('a' => 'avalue3'))]));
// $d      = service\ElasticSearchService::search_filter('/hello/world', $filter);
// var_dump($d);
// exit;

// 与查询
// $filter = array('and' => array('filters' => [array('term' => array('a' => 'avalue3')), array('term' => array('a' => 'avalue2'))]));
// $d      = service\ElasticSearchService::search_filter('/hello/world', $filter);
// var_dump($d);

// 或查询
// $filter = array('or' => array('filters' => [array('term' => array('a' => 'avalue3')), array('term' => array('a' => 'avalue2'))]));
// $d      = service\ElasticSearchService::search_filter('/hello/world', $filter);
// var_dump($d);
// exit;

// 通配符查询
// $query = array('wildcard' => array('a' => '*value*'));
// $d     = service\ElasticSearchService::query('/hello/world', $query);
// var_dump($d);
// exit;

// 正则查询
// $query = array('regexp' => array('a' => 'value[0-9].*'));
// $d     = service\ElasticSearchService::query('/hello/world', $query);
// var_dump($d);
// exit;

// 多条件或查询
// $query  = array('term' => array('a' => 'avalue3'));
// $query2 = array('term' => array('b' => 'bvalue2'));
// $should = array('bool' => array('should' => [$query, $query2]));
// $d      = service\ElasticSearchService::query('/hello/world', $should);
// var_dump($d);
// exit;
