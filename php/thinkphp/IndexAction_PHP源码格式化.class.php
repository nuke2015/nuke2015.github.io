<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
    	$str=file_get_contents('Model.class.php');
    	$tokens=token_get_all($str);
    	if(count($tokens)){
    		foreach ($tokens as &$value) {
    			$value['name']=token_name($value[0]);
    			print_r($value);
    		}
    	}
    	exit;
    }
}