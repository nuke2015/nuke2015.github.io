<?
#���û�+ģ������;
function sid($sid){
	$sid.=MODULE_NAME;
	$sid.=session_id(); //session����,����������������;
	return md5($sid);
}
#�����ļ�����,key������,valueֵ;
function kvdb($key,$value=null){
	include_once(APP_PATH.'Lib/ORG/Secache.class.php');
	$cache=new secache();
	$cache->workat(RUNTIME.'KVDB');
	if(!isset($value)){
		$cache->fetch(md5($key),$rs); //ȡ����;
		return unserialize($rs);
	}else{
		if(!empty($value)){
			$cache->store(md5($key),serialize($value)); //�������л�,����ջ���;
		}else{
			$cache->delete(md5($key)); //ɾ������;
		}
	}
}