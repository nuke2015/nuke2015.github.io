<?php

/**
 * 基础数据类
 * 
 * 此类有个蛋疼的地方:
 * 没有debug选项,有时sql报错不执行,都不知道是怎么错的.
 * 一般是字段与库里不一致.比如,多字段,少字段,大小写.
 * 优化建议:
 * 此类连接句柄用的是全局变量,
 * 根据面向对象的原则,应该尽量减少全局变量的使用.
 * 可以改成静态static变量.
 * 因为全局变量对于框架加载的其它代码有侵入性.
 * 
 */
class database
{
    
    /**
     * 数据库连接器
     * @var null
     */
    private $sql = null;
    private $table = null;
    private $pkey = null;
    
    /**
     * 初始化构造函数
     */
    public function __construct($table, $pkey) {
        global $db_sql;
        $this->table = $table;
        $this->pkey = $pkey;
        $this->sql = $db_sql;
    }
    
    /**
     * 获取数量Count值
     * @param string $where 过滤条件，例 where is_good=1
     * @return mixed
     */
    public function get_count($where = null) {
        return $this->sql->get_count($this->table, $where);
    }
    
    /**
     * 获取第一行第一格的数据
     * @param $key int || string 主键值
     * @param string $cols
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_one_with_key($key, $cols = '*', $order = null) {
        return $this->sql->get_one($this->table, $cols, 'where ' . $this->pkey . '=\'' . $key . '\'', $order);
    }
    
    /**
     * 获取第一行第一格的数据
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $cols 输出指定的字段，只能是一个字段
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_one_with_where($where, $cols = '*', $order = null) {
        return $this->sql->get_one($this->table, $cols, $where, $order);
    }
    
    /**
     * 获取一行数据
     * @param $key int || string 主键值
     * @param string $cols
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_row_with_key($key, $cols = '*', $order = null) {
        return $this->sql->get_row($this->table, $cols, 'where ' . $this->pkey . '=\'' . $key . '\'', $order);
    }
    
    /**
     * 获取一行数据
     * @param $where string 数据条件
     * @param string $cols string 输出的字段，默认是*
     * @param $order string 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_row_with_where($where, $cols = '*', $order = null) {
        return $this->sql->get_row($this->table, $cols, $where, $order);
    }
    
    /**
     * 从DB中获取列表数据
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $cols 输出的字段，默认是*
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @param int $size 输出行数量，0表示全部输出
     * @return mixed
     */
    public function get_list($where = null, $cols = '*', $order = null, $size = 0) {
        return $this->sql->get_list($this->table, $cols, $where, $order, $size);
    }
    
    /**
     * 翻译列表数据
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $cols 输出的字段
     * @param string $order 排序方法，例 act_date asc, rpt_date desc
     * @param int $page 页码
     * @param int $size 每页输出行数量
     * @param int $count 总记录数（返回值）
     * @return mixed
     */
    public function get_pager($where, $cols, $order, $page, $size, &$count = 0) {
        if ($page <= 0) {
            $page = 1;
        }
        return $this->sql->get_pager($this->table, $cols, $where, $order, $page, $size, $count);
    }
    
    /**
     * 删除表所有数据
     */
    public function delete() {
        $this->sql->delete($this->table, null);
    }
    
    /**
     * 删除表数据
     * @param string $key int || string 主键值
     */
    public function delete_with_key($key) {
        $this->sql->delete($this->table, 'where ' . $this->pkey . '=\'' . $key . '\'');
    }
    
    /**
     * 删除表数据
     * @param string $where 过滤条件，例 where is_good=1
     */
    public function delete_with_where($where = null) {
        $this->sql->delete($this->table, $where);
    }
    
    /**
     * 使用STM参数方法删除数据
     * @param string $where 过滤条件，例 where title=?
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function delete_with_stm($where, $params) {
        $this->sql->delete_with_stm($this->table, $where, $params);
    }
    
    /**
     * 使用STM参数方法删除数据
     * @param string $key int || string 主键值
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function delete_with_stm_and_key($key, $params) {
        $this->sql->delete_with_stm($this->table, 'where ' . $this->pkey . '=\'' . $key . '\'', $params);
    }
    
    /**
     * @param $info string, 例 info['Title'] = 'title值'
     * @param $return bool
     * @return int
     */
    public function insert($info, $return = false) {
        $this->sql->insert($this->table, $info);
        if ($return) {
            return $this->sql->get_last_insert_id();
        }
        return 0;
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     * @param bool $return 是否返回主键值
     * @return int
     */
    public function insert_with_stm($params, $return = false) {
        $this->sql->insert_with_stm($this->table, $params);
        if ($return) {
            return $this->sql->get_last_insert_id();
        }
        return 0;
    }
    
    /**
     * 更新数据
     * @param string $where 过滤条件，例 where title='title值'
     * @param array $info 插入的数据值，例 info['Title'] = 'title值'
     */
    public function update($where, $info) {
        $this->sql->update($this->table, $where, $info);
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param $key int || string 主键值
     * @param $info array 插入的数据值，例 info['Title'] = 'title值'
     */
    public function update_with_key($key, $info) {
        $this->sql->update($this->table, 'where ' . $this->pkey . '=\'' . $key . '\'', $info);
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param string $where 过滤条件，例 where title=?
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function update_with_stm($where, $params) {
        $this->sql->update_with_stm($this->table, $where, $params);
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param string $key int || string 主键值
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function update_with_stm_and_key($key, $params) {
        $this->sql->update_with_stm($this->table, 'where ' . $this->pkey . '=\'' . $key . '\'', $params);
    }
    
    /**
     * 更新数据
     * @param string $where 过滤条件，例 where title='title值'
     * @param string $set set语句，例 xx='xx',yy='yy'
     */
    public function update_with_set($where, $set) {
        $this->sql->update_with_set($this->table, $set, $where);
    }
    
    /**
     * 更新数据
     * @param $key int || string 主键值
     * @param $set string set语句，例 xx='xx',yy='yy'
     */
    public function update_with_set_and_key($key, $set) {
        $this->sql->update_with_set($this->table, $set, 'where ' . $this->pkey . '=\'' . $key . '\'');
    }
    
    /**
     * 判断是否在在记录
     * @param string $key int || string 主键值
     * @return bool
     */
    public function is_exist_with_key($key) {
        return ($this->sql->get_count($this->table, 'where ' . $this->pkey . '=\'' . $key . '\'') > 0);
    }
    
    /**
     * 判断是否在在记录
     * @param string $where 过滤条件，例 where is_good=1
     * @return bool
     */
    public function is_exist_with_where($where = null) {
        return ($this->sql->get_count($this->table, $where) > 0);
    }
    
    /**
     * 在线插入数据
     */
    public function query($sql) {
        $this->sql->query($sql);
    }
    
    /**
     * 获取数据列表
     * @param string $sql
     * @return mixed
     */
    public function fetch_list($sql) {
        return $this->sql->fetch_list($sql);
    }
    
    /**
     * @param $ord string 字段_[up|down]
     * @param $default string 默认的排序
     * @return string
     */
    public function order($ord, $default) {
        if ($ord == '') {
            return $default;
        }
        if (preg_match('/^(\w+)_(up|down)$/', $ord, $match)) {
            if ($match[2] == 'up') {
                return $match[1] . ' asc';
            } else {
                return $match[1] . ' desc';
            }
        } else {
            return $default;
        }
    }
}
