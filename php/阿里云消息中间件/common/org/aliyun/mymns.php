<?php
namespace app\common\org\aliyun;

// 这刁毛写法
use AliyunMNS\Client;
use AliyunMNS\Model\SubscriptionAttributes;
use AliyunMNS\Requests\PublishMessageRequest;
// use AliyunMNS\Exception\MnsException;
use think\Config;

require __DIR__ . '/sdk_mns_aliyun_php/mns-autoloader.php';

class mymns
{
    // 连接句柄
    public static function init()
    {
        $config = Config::get('MyAliyun');
        if (!$config || !is_array($config)) {
            throw new \Exception('mns no config,yet', 60010);
        }

        $client = new Client($config['MNS_ENDPOINT'], $config['MNS_ACCESS_ID'], $config['MNS_ACCESS_KEY']);
        return $client;
    }

    // 创建主题
    public static function TopicCreate($topicName)
    {
        $request = new CreateTopicRequest($topicName);
        $client  = self::init();
        $res     = $client->createTopic($request);
        return $res;
    }

    // 主题查询
    public static function TopicGet($topicName)
    {
        $client = self::init();
        $topic  = $client->getTopicRef($topicName);
        return $topic;
    }

    // 订阅消息
    public static function subscribe($topic, $subscriptionName, $callback)
    {
        $attributes = new SubscriptionAttributes($subscriptionName, $callback);
        $res        = $topic->subscribe($attributes);
        return $res;
    }

    // 发布消息
    public static function publish($topic, $messageBody)
    {
        $request = new PublishMessageRequest($messageBody);
        $res     = $topic->publishMessage($request);
        return $res;
    }

    // 签名
    public static function sign($timenow)
    {
        $config = Config::get('MyAliyun');
        return md5(md5($config['MNS_SIGN']) . md5($timenow));
    }

    // 发消息;
    public static function base64_send($topicName, $data)
    {
        $timenow       = time();
        $param         = array();
        $param['time'] = $timenow;
        $param['sign'] = self::sign($timenow);
        $param['data'] = $data;

        $txt_base64 = base64_encode(json_encode($param));
        $request    = new PublishMessageRequest($txt_base64);

        $topic = self::TopicGet($topicName);
        $res   = $topic->publishMessage($request);
        return $res;
    }

    // 收消息
    public static function base64_get($txt_base64)
    {
        $param = json_decode(base64_decode($txt_base64), 1);
        if ($param && count($param)) {
            $sign = self::sign($param['time']);
            if ($param['sign'] && $sign == $param['sign']) {
                return $param['data'];
            }
        }
    }

    // 取数据体
    public static function data_get()
    {
        $xml = self::xml_get();
        if ($xml['Message']) {
            // 签名校验
            return self::base64_get($xml['Message']);
        }
    }

    // 被动接收xml输入
    public static function xml_get()
    {
        try {
            $input = file_get_contents("php://input");
            if ($input) {
                $result = new \SimpleXMLElement($input);
                return (array) $result;
            }
        } catch (Exception $e) {

        }
    }

}
