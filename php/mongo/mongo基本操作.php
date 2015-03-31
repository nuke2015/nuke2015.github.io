<?php
header("Content-type: text/html;charset=utf-8");

//$mongo = new Mongo();
//$databases = $mongo->listDBs();
$options = array('timeout'=>100);
$mongo = new Mongo($server='mongodb://admin:admin@127.0.0.1:27017/fengsu');

//$mongo = new Mongo($options);
$clt=$mongo->livedecoration->message;
$count=$clt->count();
dump($count);
$one=$clt->findone();
dump($one);
exit;








exit;


/**
 * 以下是分段测试代码
 * nuke.zou  锋子
 * 2013年7月12日 10:04:02
 * 注意事项:需要安装php_mongo.dll扩展!
 * 更多高级用法,见官方文档
 * http://php.net/manual/zh/book.mongo.php
 * 喔耶!
 */


//子数组多个插入;
$diary['hello']='world';
$diary['title']='feng';
$data['title']='xianchang';
$data['createtime']=time();
$data['diary'][]=$diary;
$data['diary'][]=$diary;
$data['diary'][]=$diary;
$do=$shop->insert($data);
dump($do);
exit;


//子数组插入;
$diary['hello']='world';
$diary['title']='feng';
$data['title']='xianchang';
$data['createtime']=time();
$data['diary']=$diary;
$do=$shop->insert($data);
dump($do);
exit;


//数据插入;
$data['hello']='world';
$data['title']='feng';
$do=$shop->insert($data);
dump($do);
exit;


//根据主键删除;
//注意状态码,一直返回1;
$status=$shop->remove(array('_id'=>new MongoId('53bf55eda1ec07c800000003')));
dump($status);
exit;


//条件式删除;
$status=$shop->remove(array('name'=>'dsf'));
dump($status);
exit;


//覆盖式更新;
$data['name']='update name';
$data['address']='update address';
$status=$shop->update(array('tel'=>'we'),$data);
dump($status);
exit;


//字段内容更新;
$data['name']='update name';
$data['address']='update address';
$status=$shop->update(array('tel'=>'we'),array('$set'=>$data));
dump($status);
exit;


//直接命令查询;
$cursor=$mongo->fengsu->command(array('distinct'=>'shop','key'=>'name'));
dump($cursor);   	
exit;


//特定条件查找;
$cursor=$shop->find(array('name'=>'sfds'));
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//正则条件查找
$cursor=$shop->find(array('name'=>new MongoRegex('/fs/')));
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//排序,倒序
$cursor=$shop->find()->sort(array('_id'=>-1));
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//翻页
$cursor=$shop->find()->limit(2)->skip(2);
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//条数控制
$cursor=$shop->find()->limit(2);
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//查看列表;
$cursor=$shop->find();
echo $cursor->count();
foreach($cursor as $item){
	dump($item);   	
}
exit;


//辅助函数,变量查看
function dump($v){
	echo '<pre>';
	print_r($v);
	echo '</pre>';
}




