<?php

//thinkphp事务支持
$dishes_tags_sorter = D('dishes_tags_sorter');
$dishes_tags_sorter->startTrans();
for($i=0;$i<10;$i++){
    $data=array();
    $dishes_tags_sorter->data($data)->add();
}
$dishes_tags_sorter->commit();
$dishes_tags_sorter->rollback();

