<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        $UserModel=D('User');
        $data= $UserModel->relation(true)->find(1);
        echo $UserModel->getLastsql();
        print_r($data);
        exit;
    }
}