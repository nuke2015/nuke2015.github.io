<?php
echo '<pre>';

$mongo = new MongoClient($server = 'mongodb://127.0.0.1:27017/test');
$c = $mongo->test->pan;
$data = array('title' => 'this is my title', 'author' => 'bob'.rand(0,10), 'posted' => new MongoDate, 'pageViews' => 5, 'tags' => array('fun', 'good', 'tagrand'.rand(0,5)), 'comments' => array(array('author' => 'joe', 'text' => 'this is cool',), array('author' => 'sam', 'text' => 'this is bad',),), 'other' => array('foo' => 5,),);

print_r($data);
$d = $c->insert($data, array("w" => 1));

$ops = array(array('$project' => array("author" => 1, "tags" => 1,)), array('$unwind' => '$tags'), array('$group' => array("_id" => array("tags" => '$tags'), "authors" => array('$addToSet' => '$author'),),),);

$results = $c->aggregate($ops);
print_r($results);

