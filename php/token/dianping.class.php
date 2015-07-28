<?php

// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action
{
    public function index() {
        
        if (API_TOKEN_CHECK) $this->check_token();
        
        //默认路由
        $this->result(ERR_NONE, 'Welcome to bestphp.net');
    }
    
    /**
     * 数据输出;
     * @param  [type]  $data [description]
     * @param  integer $code [description]
     * @param  string  $msg  [description]
     * @return [type]        [description]
     */
    public function result($code = 0, $data = null, $msg = '') {
        global $ERROR_MSG;
        if (isset($ERROR_MSG[$code])) {
            $msg = $ERROR_MSG[$code];
        }
        $return = json_encode(array('code' => strval($code), 'msg' => $msg, 'data' => (object)$data), JSON_UNESCAPED_UNICODE);
        echo $return;
        exit;
    }
    
    /**
     * 来访请求,通信指纹校验
     * @return [type] [description]
     */
    public function check_token() {
        $param = $_POST;
        
        //指纹校验,只有token或无token都校验不通过!
        if (!isset($param['token']) || count($param) == 1) {
            $this->result(ERR_WRONG_SIGN);
        } else {
            $token_check = strtoupper($param['token']);
            unset($param['token']);
            $token_real = $this->make_token($param);
            if ($token_real != $token_check) {
                $this->result(ERR_WRONG_SIGN);
            }
        }
    }
    
    /**
     * 通信指纹计算
     * @return [type] [description]
     */
    public function make_token($param) {
        ksort($param);
        $str_check = '';
        if (count($param)) {
            foreach ($param as $key => $value) {
                if ($key == 'token') continue;
                $str_check.= $key . $value;
            }
            $str_check.= API_TOKEN;
        }
        $token_real = md5($str_check);
        $token_real = strtoupper($token_real);
        return $token_real;
    }
}
