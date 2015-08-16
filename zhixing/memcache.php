<?php

/**
 * memcache类
 * 历史上,$value为字符串时正常.为object时数据取回,偶尔会失效.
 * 所以,保存之前做下序列化比较好.
 *
 * 优化建议:
 * 修改成静态调用.
 * 用static配置静态连接
 *
 */
class cache
{
    
    /**
     * 标识是否为Linux下的Memcache模块
     * @var bool
     */
    private $is_memcached = false;
    private $object = null;
    
    public function __construct($conf) {
        
        //判断哪个模块
        if (class_exists('memcached')) {
            $this->is_memcached = true;
        }
        
        //实例化并加入数据池
        if ($this->is_memcached) {
            $this->object = new Memcached();
        } else {
            $this->object = new Memcache();
        }
        foreach ($conf as $value) {
            $this->object->addServer($value[0], $value[1], $value[2]);
        }
    }
    
    /**
     * 是否启用memcached（Linux版本）
     * @return bool
     */
    private function is_memcached() {
        
        //return false; //开关使用
        if (class_exists('memcached')) {
            return true;
        }
        return false;
    }
    
    /**
     * 把数据对象加入缓存池
     * @param $key
     * @param $value
     * @param int $expire
     */
    public function set($key, $value, $expire = 0) {
        if ($this->is_memcached) {
            $this->object->set($key, $value, $expire);
        } else {
            $this->object->set($key, $value, 0, $expire);
        }
    }
    
    /**
     * 从缓存池中获取数据对象
     * @param string $key
     * @return array|string
     */
    public function get($key) {
        if ($this->is_memcached && is_array($key)) {
            return $this->object->getMulti($key);
        } else {
            return $this->object->get($key);
        }
    }
    
    /**
     * 从缓存池中获删除数据对象
     * @param string $key
     */
    public function delete($key) {
        $this->object->delete($key);
    }
    
    /**
     * 关闭连接
     * @return mixed
     */
    public function close() {
        if ($this->is_memcached) {
            return $this->object->quit();
        } else {
            return $this->object->close();
        }
    }
}
