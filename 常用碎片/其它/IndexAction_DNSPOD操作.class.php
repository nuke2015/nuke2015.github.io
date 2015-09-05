<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    
	public function index(){
		$do['sub_domain']='www';
		$do['record_type']='A';//ip
		$do['record_line']='默认';
		$do['value']='127.0.0.1';
		$do['mx']='-';
		$do['ttl']=600;
		$this->recodecreate($do);
		$do['sub_domain']='@'; //无www的.
		$this->recodecreate($do);
		$this->recordlist(); //查看列表;
	}
	#记录列表;
	public function recordlist(){
		$url='https://dnsapi.cn/Record.List';
		$tmp=$this->config();
		$tmp['domain_id']=$this->domainid();
		$tmp['offset']=0;
		$tmp['length']=20;
		$json=$this->curl($url,$tmp);
		dump($json);
	}
	#添加记录;
	public function recodecreate($res){
		$url='https://dnsapi.cn/Record.Create';
		$tmp=$this->config();
		$tmp['domain_id']=$this->domainid();
		$tmp=array_merge($tmp,$res);
		$json=$this->curl($url,$tmp);
		dump($json);
	}
	#域名id;
	public function domainid(){
		$url='https://dnsapi.cn/Domain.info';
		$tmp=$this->config();
		$tmp['domain']='9yk.me';
		$json=$this->curl($url,$tmp);
		$decode=json_decode($json);
		if($decode->status->code=='1'){
			return $decode->domain->id;
		}else{
			dump($decode);
		}	
	}
	#添加新域名
	public function domaincreate(){
		$url='https://dnsapi.cn/Domain.Create';
		$tmp=$this->config();
		$tmp['domain']='9yk.me';
		$json=$this->curl($url,$tmp);
		dump($json);
	}
	#采集;
	private function curl($url,$param){
		import('@.ORG.Http');
		$http=new Http();
		return $http->curl($url,$param,'POST');
	}
	#公共参数;
	private function config(){
		$tmp['login_email']='登陆名';
		$tmp['login_password']='用户密码';
		$tmp['format']='json';
		$tmp['lang']='en';
		$tmp['error_on_empty']='yes';
		return $tmp;
	}
}