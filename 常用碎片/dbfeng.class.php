<?php
class dbfeng{
	/*
	利用F()函数,进行数据库全库备份;
	适用于各种云环境.
	#数据备份
	import('@.ORG.dbfeng');
	$dbf=new dbfeng();
	$do=$dbf->backup('DBBAK');
	dump($do); //返回清单文件
	exit;
	#数据还原;
	import('@.ORG.dbfeng');
	$dbf=new dbfeng();
	$do=$dbf->restore('DBBAK');
	dump($do);
	*/
	public function restore($tag){
		$list=F($tag.'/info');
		if(!$list)$this->error('backup list not found!');
		if($list['FILES']){
			if(is_array($list['FILES'])){
				foreach($list['FILES'] as $item){
					$data=F($item);
					$this->tablerestore($data);
				}
			}else{
				#单个;
				$data=F($list['FILES']);
				$this->tablerestore($data);
			}
			return true;
		}else{
			return false;
		}
	}
	#全库备份;
	public function backup($tag){
		$dbname=C('DB_NAME');
		$prefix=C('DB_PREFIX');
		$result=$files=array();
		if(!$tables){
			$tables=$this->tables($dbname,$prefix);
		}
		if(is_array($tables)){
			foreach($tables as $table){
				$data=$this->tablebackup($table,$prefix);
				$to=$tag.'/'.$dbname.'/'.$table;
				$size+=$this->io($to,$data);
				$files[$table]=$to;
			}
		}else{
			//单表,不是数组;
			$data=$this->tablebackup($tables,$prefix);
			$to=$tag.'/'.$dbname.'/'.$tables;
			$size+=$this->io($to,$data); 
			$files[$tables]=$to;
		}
		$result['DB_NAME']=$dbname;
		$result['DB_PREFIX']=$prefix;
		$result['TABLES']=$tables;
		$result['FILES']=$files;
		$result['SIZE']=$size;
		$result['TIME']=time();
		F($tag.'/info',$result); //写入清单文件;
		return $result;
	}
	#单表还原;
	public function tablerestore($data){
		$data=unserialize($data);//反序列化;
		if(!$data['table'])return $do['error']='table pls!';
		$model=M($data['table'],$data['prefix']);
		if($data['drop']){
			$model->query($data['drop']);
		}
		if($data['struct']){
			$model->query($data['struct']);
		}
		if($list=$data['data']){
			if(is_array($list)){
				$model->startTrans();
				foreach($list as $item){
					$do=$model->data($item)->add(); //事务回滚
					if(!$do)break;
				}
				$model->commit();
			}
		}
		return $do;
	}
	#单表备份;
	public function tablebackup($table,$prefix=''){
		$result=array();
		$modelname=str_ireplace($prefix,'',$table);
		$result['table']=$modelname;
		$result['prefix']=$prefix;
		$model=M($modelname,$prefix);
		//表结构;
		$tmp=$model->query("show create table $table");
		if($tmp){
			$result['drop']="DROP TABLE IF EXISTS $table;\n"; //导入前丢弃;
			$struct=$tmp[0]['Create Table'];
			$struct = str_replace("\n","",$struct);
			$struct = str_replace("\t","",$struct);
			$struct .= ";\n";//组装字符串;
			$result['struct']=$struct;
		}
		//数据;
		$data=$model->where(1)->select();
		if($data){
			$result['data']=$data;
		}
		return $result;
	}
	#全部表格;
	public function tables($dbname){
		$model=M();
		$tables=$model->query('show tables');
		if($tables){
			$result=array();
			foreach($tables as $item){
				$result[]=$item['Tables_in_'.$dbname];
			}
		}
		return $result;
	}
	#输出;
	private function io($file,$data=null){
		if(isset($data)){
			$data=serialize($data);
			F($file,$data);
			$do=strlen($data); //返回大小;
		}else{
			$do=F($file);
			$do=unserialize($do);
		}
		return $do;
	}	
}