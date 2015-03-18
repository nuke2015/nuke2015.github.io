<?php

// header("Content-type: text/html;charset=utf-8");
define('NO_AJAX', 1);

require_once ("../../include/start_init.inc.php");
require_once (ROOT . "/gb_php/MongoBase.php");
require_once (__DIR__ . "/lib/runtime.php");
require_once (__DIR__ . "/lib/jsonlog.php");
require_once (__DIR__ . "/lib/jiankongDao.php");
require_once (__DIR__ . "/lib/Mlogger.php");

error_reporting(2047);

$jiankongDao = new jiankongDao();
$collection = $jiankongDao->collection();

// //按年月日
// db.mCollectionUsers.aggregate([
//     {$project :{
//         day : {"$dayOfMonth" : "$accountCreated"},
//         month : {"$month" : "$accountCreated"},
//         year : {"$year" : "$accountCreated"}
//     }},
//     {$group: {
//         _id : {year : "$year", month : "$month", day : "$day"},
//         accounts : { "$sum" : 1}
//     }}
// ]);

//按年月日,求平均值汇总
$match=array('key'=>80081);
$project=array('year' => array('$year' => '$ctime'), 'month' => array('$month' => '$ctime'), 'day' => array('$dayOfMonth' => '$ctime'),'t'=>1);
$ops = array(array('$match' => $match), array('$project' => $project,), array('$group' => array('_id' => array('year' => '$year', 'month' => '$month', 'day' => '$day'), 'sum' => array('$avg' => '$t'),'items'=>array('$addToSet'=>'$t')),),);
$result = $collection->aggregate($ops);

dump($result);
exit;

// exit;

//insert;
$tmp = jsonlog::get();
if ($tmp && is_array($tmp)) {
    
    //只操作单条;
    $pop = array_pop($tmp);
    
    $jiankongDao = new jiankongDao();
    foreach ($pop as $key => $log) {
        $log['key'] = $key;
        $log['ctime'] = new MongoDate(time() - rand(0, 100) * 3600);
        $log['status'] = 1;
        $insert[] = $log;
    }
    $do = $jiankongDao->batchinsert($insert);
    dump($do);
}
exit;

