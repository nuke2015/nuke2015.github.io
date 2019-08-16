<?php

namespace didiyuesao\com\mongo;

use didiyuesao\com\base;
use didiyuesao\com\config;

// 官方文档来自composer,因为php7底层的mongo实在不友好.
// https://docs.mongodb.com/php-library/master/tutorial/install-php-library/

// $hello = new mongo\hello();
// var_dump($hello);
// $data = ['title' => 'fengfeng', 'name' => '测试', 'uniq' => time().uniqid(), 'date' => date('Y-m-d H:i:s')];
// $do = $hello->insertOne($data);
// var_dump($do);
// $where = [];
// $option = [
//     // 分页
//     'limit' => 10,
//     'skip' => 1,
//     // 倒序
//     'sort' => ['_id' => -1],
// ];
// $list = $hello->find($where, $option);
// var_dump($list);

abstract class MongoBase extends base\ApiBaseAction
{
    protected static $database;
    protected static $instance;
    protected static $collection;

    //连接
    public static function init()
    {
        if (!self::$instance) {
            $connStr = config\mongodb::config();
            try {
                self::$instance = new \MongoDB\Driver\Manager($connStr);
            } catch (Exception $e) {
                throw new Exception('mongodb connect fail', 1);
            }
        }

        return self::$instance;
    }

    public function findOne($where)
    {
        //读取一条数据
        $data = $this->collection->findOne($where);

        return $data;
    }

    public function find($where, $options = [])
    {
        $cursor = $this->collection->find($where, $options);
        $dataList = $cursor->toArray();

        return $dataList;
    }

    public function count($where)
    {
        $num = $this->collection->count($where);

        return $num;
    }

    //去重查询
    public function distinct($field, $where)
    {
        $ret = $this->collection->distinct($field, $where);

        return $ret;
    }

    public function insertOne($data)
    {
        $ret = $this->collection->insertOne($data);

        return $ret->getInsertedCount();
    }

    public function insertMany($data)
    {
        $ret = $this->collection->insertMany($data);

        return $ret->getInsertedCount();
    }

    public function updateOne($where, $data)
    {
        // updateOne 参数 1 查询条件, 参数2 要更换的字段
        $ret = $this->collection->updateOne($where, array('$set' => $data));
        // 返回更新的数量
        return $ret->getMatchedCount();
    }

    //更新多条数据 和 更新一条数据基本一致只是影响的范围不同
    public function updateMany($where, $data)
    {
        // updateMany 参数1 查询条件 ,参数2 要更换的字段
        $ret = $this->collection->updateMany($where, array('$set' => $data));

        return $ret->getMatchedCount();
    }

    public function deleteOne($where)
    {
        // deleteOne 参数 1 查询语句 , 参数2
        $ret = $this->collection->deleteOne($where);

        return $ret;
    }

    //删除多条数据
    public function deleteMany($where)
    {
        // deleteMany 参数
        $ret = $this->collection->deleteMany($where);

        return $ret;
    }

    public function listIndexes($options = [])
    {
        $ret = $this->collection->listIndexes($options);

        return $ret;
    }
}
