<?php 

/* OO API */
$memcache = new Memcache;
$memcache->connect("127.0.0.1", 21201);
var_dump($memcache);
$memcache->add('memcache_test','test_'.time(), FALSE, 30);
$data=$memcache->get('memcache_test');
var_dump($data);
