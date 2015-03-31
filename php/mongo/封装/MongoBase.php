<?php
/**
 * Mongo数据操作基础类,
 * 此类不能直接初始化,
 * 只能被继承
 * 
 * nuke.zou 	锋子
 * 2014年8月6日 17:03:08
 * 
 */
abstract class MongoBase
{
    protected  $CollectionName;  //集合名称
    protected $_collection;      //集合对象,换成protected要用.
    private $_mongo;           //数据库连接
    public  $cursor;           //操作游标.
    private static $instance;
    
    public function __construct($dbname,$cname)
    {
        $CollectionName=$this->CollectionName;
        if(!$CollectionName)die('CollectionName pls!');
        $this->_mongo=self::init();
        $this->_collection = $this->_mongo->$dbname->$cname;
    }
    
    //连接
    public static function init($connStr='mongodb://192.168.1.60:27017/boss') {
        if (!self::$instance) {
            self::$instance = new MongoClient($connStr);
        }
        return self::$instance;
    }
    
    /**
     * [内容查找]
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * 参数$where可以为空,但这里不提供
     * 因为需要你明白where为空时,
     * 查的是整个数据库
     * 建议$field查询的时候也不要为空.
     * 因为此时查询返回的是整个文档.
     * 
     * @param array $where  查询条件
     * @param array  $field 查询目标    
     * @return resource 游标
     */
	public function find($where,$field=array()){
        return $this->cursor=$this->_collection->find($where,$field);
	}

    /**
     * 条数控制
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * @param int $length 数据条数   
     * @return resource 游标
     *        
     */
    public function limit($length){
        return $this->cursor=$this->cursor->limit($length);
    }

    /**
     * 位置移动
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法     * 
     * @param int $offset 跳过数据条数   
     * @return resource 游标
     * 
     */
    public function skip($offset){
        return $this->cursor=$this->cursor->skip($offset);
    }

    /* 
     * 数据排序;
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法     * 
     * @param int $length 数据条数   
     * @return resource 游标
     * 
     */
    public function sort($array){
        return $this->cursor=$this->cursor->sort($array);
    }    

    /* 
     * 查询优化跟踪;
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * 请注意此处直接返回查询数组
     * 不需要this->result();
     * @return array 查询语句完整过程
     * 
     */
    public function explain($cursor=null){
    	if(is_null($cursor))$cursor=$this->cursor;
        return $cursor->explain();
    }

    /* 
     * 数据删除;
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法     * 
     * @param array $where 条件定位   
     * @return bool 状态码
     * 
     */
    public function remove($where){
        return $this->_collection->remove($where);
    }

    /* 
     * 创建索引
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法   
     * @param int $array 索引字段数组   
     * @return resource 游标
     * 
     */
    public function ensureIndex($array){
        return $this->_collection->ensureIndex($array);
    }

    /**
	 * 游标转数组,不带键;
     * @param resource $cursor 操作游标
     * @return array 数组
     * 
     */
    public function result($cursor=null){
        if(is_null($cursor))$cursor=$this->cursor;
        return iterator_to_array($cursor,0);
    }

    /**
	 * 查询单条数据;
	 * 
	 * 请注意,此查询有limit(1)的效果,
	 * 无论结果多少条,都只返回第一条.
	 * 
	 * 它返回结果是直接数组,不返回游标.
	 * 
	 * @param  array  $where 查询条件;
	 * @param  array  $field 返回字段;
	 * @return    array    返回最终结果;
	 */
	public function findOne($where,$field=array()){
		return $this->_collection->findOne($where,$field);
	}

    /**
     * 数据插入,原状插入
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * @param array   $data   数据数组
     * @param array   $option  操作附加选项; 
     * @return resource 游标
     */
    public function insert($data,$option=array()){
        return $this->_collection->insert($data,$option);
    }

    /**
     * 批量数据插入,原状插入
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * @param array   $data   多条数据的数组
     * @param array   $option  操作附加选项;   
     * @return resource 游标
     * 
     */
    public function batchinsert($data,$option=array()){
        return $this->_collection->batchinsert($data,$option);
    }

    /**
     * 数据插入,会自动增加_id
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * @param array   $data   数据数组 
     * @param array   $option  操作附加选项;   
     * @return resource 游标
     */
    public function save($data,$option=array()){
        return $this->_collection->save($data,$option);
    }

    /**
     * 数据更新
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * 
     * 请注意:$data是mongo的完整操作数组.
     * 可以包括$set,$push,$pull...等
     * 
     * @param   array $where  条件定位数组
     * @param   array $data   数据操作数组
     * @param  array $option  是操作选项数组;
     * @return resource 操作游标
     * 
     */
    public function update($where,$data,$option=array()){
        return $this->_collection->update($where,$data,$option);
    }

    /**
     * 数据条数计算
     * 详见mongo+PHP官方,
     * 原生支持php_mongo.dll一切用法
     * $where为空时,查全库文档数据条数.
     * $where有条件时,查符合条件的数据条数;
     * 
     * @param array $where 查询条件 
     * @return int 数据条数
     * 
     */
    public function count($where=array()){
        if($where)
        {
            return $this->_collection->find($where)->count();
        }
        else
        {
            return $this->_collection->count();
        }
    }
	
    /**
	 * 根据id获取单条数据;
	 *
	 * 请注意此方法的$id参数是字符串;
	 * 
	 * @param  string   $id  文档的_id;
	 * @param  array    $fields   字段数组;
	 * @return array 直接返回文档结果数组
	 * 
	 */
	public function getById($id,$fields=array()){
		if(strlen($id) == 24){
			$id = new MongoId($id);
		}
		$cursor  = $this->_collection->find(array('_id' => $id),$fields);
		$result = $cursor->getNext();

		if (!$result){
			return false ;
		}
		return $result;
	}
}



