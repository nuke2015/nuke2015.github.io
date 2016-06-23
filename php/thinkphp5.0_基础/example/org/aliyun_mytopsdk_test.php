<?php
namespace app\api\controller;

use app\common\org\aliyun;

class Index
{
    
    // http://127.0.0.183/?s=api/index/index
    public function index() {
        
        $mytopsdk = aliyun\mytopsdk::init();
        $req_sms_send = aliyun\mytopsdk::req_sms_send('13530861042', '123457');
        $do = $mytopsdk->execute($req_sms_send);
        var_dump($do);
        exit;
    }
}
