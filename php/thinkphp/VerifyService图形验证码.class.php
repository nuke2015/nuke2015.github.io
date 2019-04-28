<?php
// app的图形验证码,基于thinkphp图形类实现
class VerifyService
{
    //生成
    public function make($ccid)
    {
        $diff_key = $this->key($ccid);
        import('@.ORG.Util.Image');
        Image::buildImageVerify();
        //更新缓存数据
        redisModel::set($diff_key, $_SESSION['verify'], 600);
        // file_put_contents('xfd.txt', json_encode($_SESSION));
    }

    // 检验
    public function check($ccid, $code)
    {
        $diff_key  = $this->key($ccid);
        $code_save = redisModel::get($diff_key);
        if ($code && $code_save == md5($code)) {
            return true;
        } else {
            return false;
        }
    }

    // 清除
    public function remove($ccid)
    {
        $diff_key = $this->key($ccid);
        redisModel::remove($diff_key);
    }

    // 统一键名
    public function key($ccid)
    {
        return 'service/VerifyService/' . strval($ccid);
    }
}
