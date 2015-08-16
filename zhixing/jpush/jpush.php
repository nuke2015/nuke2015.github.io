<?php

/**
 * 极光推送工厂类,
 * 抽象类不可直接初始化;
 * 注意:使用前需配置
 $jpush_conf = array(
 'app_key' => '',
 'master_secret' => '',
 'log_file' => 'jpush.log',
 'log_level' => Logger::DEBUG,
 );
 *
 */

require_once __DIR__ . '/autoload.php';
use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;
abstract class jpush
{
    
    public $client = null;
    public $pusher = null;
    protected $debug = false;
    
    /**
     * 配置初始化;
     * @return [type] [description]
     */
    public function init() {
        global $jpush_conf;
        $this->client = new JPushClient($jpush_conf['app_key'], $jpush_conf['master_secret']);
        return $this;
    }
    
    /**
     * 极光推送模块;
     * @return [type] [description]
     */
    public function push() {
        $this->pusher = $this->client->push();
        return $this->pusher;
    }
    
    /**
     * 是否开启调试;
     * @param [type] $stat [description]
     */
    public function setDebug($stat) {
        $stat = $stat ? true : false;
        $this->debug = $stat;
    }
}
