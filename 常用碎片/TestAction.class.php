<?php
#We are Testing
class TestAction extends AdminbaseAction {
	function _initialize(){
		exit; //功能锁;
	}
	#入口;
	function index(){
		$this->house();
		$this->business();
		$this->consum();
		$this->car();
		$this->article();
		echo 'well done!';
	}
	
	function article(){
		$key='article';
		$model=D($key);
		$cache=F($key);
		if(empty($cache)){
			$cache=$model->select();
			F($key,$cache);
		}
		$config=$this->config();
		for($i=0;$i<2500;$i++){
			$res=$cache[rand(0,4)]; //随机原始数据;
			unset($res['id']);//nop
			$res['title']=$res['title'].$i;//标题加序号;
			$cat=array(39,40,41,42,43,44,45,46,47);
			$res['catid']=$this->slice($cat,1); //随机栏目归属;
			$res['city']=$this->slice($config['city'],1); //随机栏目归属;
			$res['top']=rand(1,4); //随机置顶;
			$res['hits']=rand(1,999); //随机点击数;
			$res['updatetime']=time();
			$model->data($res)->add();
		}
		echo "$key is ok!<br>";
	}
	
	function house(){
		$key='house';
		$model=D($key);
		$cache=F($key);
		if(empty($cache)){
			$cache=$model->select();
			F($key,$cache);
		}
		$config=$this->config();
		for($i=0;$i<600;$i++){
			$tmp=$this->modify($cache[rand(0,1)]);
			$tmp['leixinghouse']=$this->slice($config['leixinghouse']);
			$tmp['firsthouse']=$this->slice($config['firsthouse']);
			$tmp['sechouse']=$this->slice($config['sechouse']);
			$model->data($tmp)->add();
		}
		#echo $model->getLastSql().'<br/>';
		echo "$key is ok!<br>";
	}
	
	function business(){
		$key='business';
		$model=D($key);
		$cache=F($key);
		if(empty($cache)){
			$cache=$model->select();
			F($key,$cache);
		}
		for($i=0;$i<600;$i++){
			$tmp=$this->modify($cache[rand(0,1)]);
			$cat=array(52,53,0);
			$tmp['catid']=$this->slice($cat,1);
			$model->data($tmp)->add();
		}
		echo "$key is ok!<br>";
	}
	
	function consum(){
		$key='consum';
		$model=D($key);
		$cache=F($key);
		if(empty($cache)){
			$cache=$model->select();
			F($key,$cache);
		}
		for($i=0;$i<1800;$i++){
			$tmp=$this->modify($cache[rand(0,1)]);
			$cat=array(48,49,50,51);
			$tmp['catid']=$this->slice($cat,1);
			$model->data($tmp)->add();
		}
		echo "$key is ok!<br>";
	}
	
	function car(){
		$key='car';
		$model=D($key);
		$cache=F($key);
		if(empty($cache)){
			$cache=$model->select();
			F($key,$cache);
		}
		$config=$this->config();
		for($i=0;$i<600;$i++){
			$tmp=$this->modify($cache[rand(0,1)]); //随机原始数据;
			$tmp['leixing']=$this->slice($config['leixingcar']);
			$tmp['yongtu']=$this->slice($config['yongtu']);
			$tmp['paizhao']=$this->slice($config['paizhao']);
			$tmp['firstpay']=rand(0,9); //首付几成;
			$model->data($tmp)->add();
		}
		echo "$key is ok!<br>";
	}
	
	#可变项;
	function modify($res){
		$config=$this->config();		
		unset($res['id']); //nop
		$res['sum']=$this->slice($config['sum'],1); //随机切一;
		$res['deadline']=$this->slice($config['deadline'],1);
		$res['deadlinemin']=$res['deadline']-rand(1,3); //原值加减;
		$res['deadlinemax']=$res['deadline']+rand(3,10);
		$res['amountmin']=$res['amountmin']-rand(0,1);//原值变化;
		$res['amountmax']=$res['amountmin']+rand(5,10);		
		$res['monthpay']=rand(1500,8500); //随机处理;
		$res['totalfee']=rand(1,100);
		$res['fangkuan']=rand(1,5);
		$res['shenpi']=rand(1,3);
		$res['apr']=rand(1,100)/100;
		$res['monthfee']=rand(1,5);
		$res['title']=$res['title'];
		$res['jigou']=$this->slice($config['jigou'],1);
		$res['danbao']=$this->slice($config['danbao'],1);
		$res['payment']=$this->slice($config['payment'],1);
		$res['top']=$this->slice($config['top'],1);
		$do=array('tedian','zhiye','gongzi','xinyong','fangchan','diya'); //批量切片;
		foreach($do as $dd){
			$res[$dd]=$this->slice($config[$dd]); //随机切片;
		}
		$res['city']=$this->slice($config['city'],1);//随机切一;
		return $res;
	}
	
	#数组切片;
	function slice($array,$count=null){
		if(count($array)<1)return $array;//字符串直接返回;
		$len=count($array);
		while(count($tmp)<1){
			if(isset($count)){
				$tmp=array_slice($array,rand(0,$len-1),$count);
			}else{
				$tmp=array_slice($array,rand(0,$len-1),rand(0,$len-1));
			}
		}
		return implode(',',$tmp);
	}
	
	#系统配置;
	function config(){
		$result['sum']=array(10,15,20,25,30,35,40,45,50); //金额;
		$result['deadline']=array(1,2,3,5,6,8,10,12,24,60,120);//期限;
		$result['jigou']=array(1,2,3,4); //机构类型;
		$result['danbao']=array(1,2,3); //担保;
		$result['payment']=array(1,2,3); //付款方式;
		$result['tedian']=array('5','7','f'); //产品特点;
		$result['zhiye']=array(1,2,3,4,5,6,7,8); //职业类型;
		$result['gongzi']=array(1,2,3,4,5,6,7,8,9,10,101,102,103,104,105); //工资;
		$result['xinyong']=array(1,2); //信用
		$result['fangchan']=array(1,2,3); //房产;
		$result['diya']=array(1,2,3,4,5,6,7); //抵押;
		$result['city']=array(860755,860760,860756,860769,860752); //城市;
		$result['paizhao']=$result['yongtu']=$result['leixingcar']=array(1,2); //牌照;
		$result['leixinghouse']=array(1,2,3,4,5,6,7,8,9,10); //房产类型;
		$result['firsthouse']=$result['sechouse']=array(1,2); //是否;
		$result['top']=array(1,2,3,4);
		return $result;
	}
}
?>