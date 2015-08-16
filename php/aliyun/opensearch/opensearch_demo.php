<?php
echo '<pre>';

require_once("/opensearch_v2.0.6/CloudsearchClient.php");
require_once("/opensearch_v2.0.6/CloudsearchIndex.php");
require_once("/opensearch_v2.0.6/CloudsearchDoc.php");
require_once("/opensearch_v2.0.6/CloudsearchSearch.php");

$access_key = "替换成自己的accesskey";
$secret = "替换成自己的Secret";

// 连接服务
//杭州公网API地址：http://opensearch-cn-hangzhou.aliyuncs.com
//北京公网API地址：http://opensearch-cn-beijing.aliyuncs.com 
$host = "http://opensearch-cn-hangzhou.aliyuncs.com";//根据自己的应用区域选择API
$key_type = "aliyun";  //固定值，不必修改
$opts = array('host'=>$host);
$client = new CloudsearchClient($access_key,$secret,$opts,$key_type);
dump($client);

// 创建应用
// 指定即将创建的应用名称
$app_name = "sdk_user_demo";
$index = new CloudsearchIndex($app_name,$client);
// $result = $index->createByTemplateName("builtin_novel");
// dump($result);

// 上传文档
$doc_obj = new CloudsearchDoc($app_name,$client);
$docs_to_upload = array();
for ($i = 0; $i < 10; $i++){
    $item = array();
    //指定文档操作类型为：添加
    $item['cmd'] = 'ADD';
    //添加文档内容
    $item["fields"] = array("id" => $i + 1,
        "title" => "我是一条新文档的标题",
        "body" => "我是一条新文档的body",
        "url" => "http://opensearch-cn-hangzhou.aliyuncs.com",
        "create_timestamp" => time());
    $docs_to_upload[] = $item;
}
//生成json格式字符串
$json = json_encode($docs_to_upload);
// 将文档推送到main表中
// $result=$doc_obj->add($json,"main");
// dump($result);

// 实例化一个搜索类
$search_obj = new CloudsearchSearch($client);
// 指定一个应用用于搜索
$search_obj->addIndex($app_name);
// 指定搜索关键词
$search_obj->setQueryString("default:我是一条");
// 指定返回的搜索结果的格式为json
$search_obj->setFormat("json");
// 执行搜索，获取搜索结果
$json = $search_obj->search();
// 将json类型字符串解码
$result = json_decode($json,true);
dump($result);
$client->getRequest();
dump($debug);


exit;

//结果查看
function dump($v){
    echo '<pre>';
    print_r($v);
    echo '</pre>';
}

