<?
#单用户+模块区分;
function sid($sid){
	$sid.=MODULE_NAME;
	$sid.=session_id(); //session跟踪,不可用于敏感数据;
	return md5($sid);
}
#快速文件缓存,key变量名,value值;
function kvdb($key,$value=null){
	include_once(APP_PATH.'Lib/ORG/Secache.class.php');
	$cache=new secache();
	$cache->workat(RUNTIME.'KVDB');
	if(!isset($value)){
		$cache->fetch(md5($key),$rs); //取缓存;
		return unserialize($rs);
	}else{
		if(!empty($value)){
			$cache->store(md5($key),serialize($value)); //数据序列化,或清空缓存;
		}else{
			$cache->delete(md5($key)); //删除缓存;
		}
	}
}