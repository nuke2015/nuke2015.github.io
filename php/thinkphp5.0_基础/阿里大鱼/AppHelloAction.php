<?php
namespace app\api\controller;

use app\common\org\aliyun;

class AppHelloAction
{

    // http://127.0.0.183/?s=api/index/index
    public function index()
    {
        $client = aliyun\mytopsdk::init();
        $req    = aliyun\mytopsdk::req_sms_send('13530861042', '8868');
        $resp   = $client->execute($req);
        var_dump($resp);
        exit;

        return array(ERR_NONE, 'AppHelloAction');
    }
}
