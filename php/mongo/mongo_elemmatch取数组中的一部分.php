<?php

$live=new Live();
$ids='53d1d01fa806e59007000029,53d09b2fa806e5cc0a00002c,53d1ed9aa806e5f40700002e';
$ids=explode(',',$ids);
$ids=array_map('mongoid',$ids);
$where=array('$in'=>$ids);
$where=array('diaries._id'=>$where);

$field=array('$in'=>$ids);
$field=array('_id'=>$field);
$field=array('$elemMatch'=>$field);
$field=array('diaries'=>$field,'diaries.title'=>1);

dump($field);

$live->find($where,$field);
$c=$live->result();
dump($c);


//转为对象;
function mongoid($id){
	return new MongoId($id);
}
exit;

$where=array('diaries._id'=>new MongoId());
$count=$live->count(); //总现场条数;
echo($count);


// $cursor=$live->find(array(),array());
// while($data=$cursor->getNext()){
// 	repair_live($data);
// 	echo $data['_id'].'<br>';
// 	ob_flush();
// 	flush();
// }
echo 'well done!!';

exit;


//封面修复;
function repair_live(&$data){
	if($data['diaries']){
		foreach($data['diaries'] as $diary){
			if($diary['images'])
			{
				foreach($diary['images'] as &$image){
					if(isset($image['path']))continue;
					if($image){
						$tmp=getimagesize($image);
						$image=array(
							'path'=>$image,
							'width'=>$tmp[0],
							'height'=>$tmp[1],
						);
					}
				}
			}
		}
	}
}

