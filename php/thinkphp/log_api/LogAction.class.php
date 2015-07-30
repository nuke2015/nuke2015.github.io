<?php

/**
 * 本页面放的是静态接口,仅供演示
 */
class LogAction extends BaseAction
{
    public function index() {
        

        //默认第一页;
        $page = intval($_GET['p']);
        if ($page < 1) {
            $page = 1;
        }
        
        //默认每页10条;
        $size = intval($_GET['size']);
        if (!$size) {
            $size = 20;
        }
        
        import("@.ORG.Page");
        $where = $this->search();
        $api_access_log = D('api_access_log');
        
        $count = $api_access_log->where($where)->count();
        $result = array();
        if ($count) {
            $Page_helper = new Page($count, $size, $page);
            $list = $api_access_log->where($where)->order('create_time desc')->limit($Page_helper->firstRow . ',' . $Page_helper->listRows)->select();
			$this->assign('pager',$Page_helper->show());           
			$this->assign('data',$list);           
        }
        $this->display();
    }

    private function search(){
    	$where=array();
    	$keyword=get_safe_replace($_POST['keyword']);
    	if($_POST['type']=='title'){
    		$where['title']=array('like',"%{$keyword}%");
    	}
    	if($_POST['type']=='ip'){
    		$where['ip']=array('like',"%{$keyword}%");
    	}
    	if($_POST['type']=='spent'){
    		$where['spent']=array('gt',$keyword);
    	}
    	return $where;
    }

    public function view(){
    	$id=intval($_GET['id']);
    	$api_access_log=D('api_access_log');
    	$data=$api_access_log->where("id={$id}")->find();
    	$this->assign('data',$data);
    	$this->display();
    }
}
