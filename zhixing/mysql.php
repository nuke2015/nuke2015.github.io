<?php

/**
 * mysql+stm?
 */
class MySQL extends mysqli
{
    public $sql = '';
    
    public function get_sql() {
        return $this->sql;
    }
    
    public function __construct($conf) {
        parent::__construct($conf['host'], $conf['user'], $conf['pass'], $conf['db'], $conf['port']);
        parent::set_charset('utf8');
    }
    
    /**
     * 获取第一行第一格的数据，SQL语言上自动加上 limit 1;
     * @param string $sql
     * @return null
     */
    public function fetch_one($sql) {
        $result = parent::query($sql . ' limit 1;');
        if (@$result->num_rows == 0) {
            return false;
        }
        $row = $result->fetch_row();
        $result->close();
        return $row[0];
    }
    
    /**
     * 获取单条记录，SQL语言上自动加上 limit 1;
     * @param string $sql
     * @return mixed
     */
    public function fetch_row($sql) {
        $result = parent::query($sql . ' limit 1;');
        if (@$result->num_rows == 0) {
            return array();
        }
        $row = $result->fetch_assoc();
        $result->close();
        return $row;
    }
    
    /**
     * 获取数据列表
     * @param string $sql
     * @return mixed
     */
    public function fetch_list($sql) {
        $this->sql = $sql;
        $result = parent::query($sql);
        if ($result->num_rows == 0) {
            return array();
        }
        $all = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $all;
    }
    
    /**
     * 获取数量count值
     * @param $table string 表名
     * @param $where string 过滤条件，例 where is_good=1
     * @return int
     */
    public function get_count($table, $where) {
        $result = parent::query("select count(*) from $table $where;");
        $row = $result->fetch_row();
        $result->close();
        return $row[0];
    }
    
    /**
     * 获取第一行第一格的数据
     * @param string $table 表名
     * @param string $cols 输出指定的字段，只能是一个字段
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_one($table, $cols, $where = null, $order = null) {
        if ($order != null) {
            $order = ' order by ' . $order;
        }
        return $this->fetch_one("select $cols from $table $where $order");
    }
    
    /**
     * 获取第一行数据
     * @param string $table 表名
     * @param string $cols 输出指定的字段，默认是*
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @return mixed
     */
    public function get_row($table, $cols = '*', $where = null, $order = null) {
        if ($order != null) {
            $order = ' order by ' . $order;
        }
        return $this->fetch_row("select $cols from $table $where $order");
    }
    
    /**
     * 从DB中获取列表数据
     * @param string $table 表名
     * @param string $cols 输出的字段，默认是*
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $order 排序方法，默认null，例 act_date asc, rpt_date desc
     * @param int $size 输出行数量，0表示全部输出
     * @return mixed
     */
    public function get_list($table, $cols = '*', $where = null, $order = null, $size = 0) {
        $limit = null;
        if ($size > 0) {
            $limit = ' limit ' . $size;
        }
        if ($order != null) {
            $order = ' order by ' . $order;
        }
        return $this->fetch_list("select $cols from $table $where $order $limit");
    }
    
    /**
     * 翻译列表数据
     * @param string $table 表名
     * @param string $cols 输出的字段
     * @param string $where 过滤条件，例 where is_good=1
     * @param string $order 排序方法，例 act_date asc, rpt_date desc
     * @param int $page 页码
     * @param int $size 每页输出行数量
     * @param int $count 总记录数（返回值）
     * @return mixed
     */
    public function get_pager($table, $cols, $where, $order, $page, $size, &$count) {
        if ($order != null) {
            $order = ' order by ' . $order;
        }
        $offset = $size * ($page - 1);
        
        //获取记录数
        $result = parent::query("select count(*) from $table $where;");
        if ($result->num_rows == 0) {
            $count = 0;
        }
        $row = $result->fetch_row();
        $result->close();
        $count = $row[0];
        
        $this->sql = "select $cols from $table $where $order limit $offset,$size;";
        
        //获取数据列表
        return $this->fetch_list("select $cols from $table $where $order limit $offset,$size;");
    }
    
    /**
     * 删除表数据
     * @param string $table 表名
     * @param string $where 过滤条件，例 where is_good=1
     */
    public function delete($table, $where = null) {
        if ($where == null) {
            parent::query("truncate table $table;");
        } else {
            parent::query("delete from $table $where;");
        }
    }
    
    /**
     * 插入数据
     * @param string $table 表名
     * @param array $info 插入的数据值，例 info['Title'] = 'title值'
     */
    public function insert($table, $info) {
        $cols = array();
        $vals = array();
        foreach ($info as $key => $value) {
            $value = preg_replace("/'/", "''", $value);
            array_push($cols, $key);
            array_push($vals, "'" . $value . "'");
        }
        $sql1 = implode(",", $cols);
        $sql2 = implode(",", $vals);
        
        parent::query("insert into $table($sql1) values ($sql2);");
        unset($cols);
        unset($vals);
    }
    
    /**
     * 更新数据
     * @param string $table 表名
     * @param string $where 过滤条件，例 where title='title值'
     * @param array $info 插入的数据值，例 info['Title'] = 'title值'
     */
    public function update($table, $where, $info) {
        $args = array();
        foreach ($info as $key => $value) {
            $value = preg_replace("/'/", "''", $value);
            array_push($args, $key . "='" . $value . "'");
        }
        $sql = implode(",", $args);
        parent::query("update $table set $sql $where");
        unset($args);
    }
    
    /**
     * 使用STM参数方法删除数据
     * @param string $table 表名
     * @param string $where 过滤条件，例 where title=?
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function delete_with_stm($table, $where, $params) {
        $type = '';
        $vals = array();
        foreach ($params as $item) {
            $type.= $item[0];
            $vals[] = $item[1];
        }
        
        $stmt = self::call_statement("delete from $table $where;", $type, $vals);
        $stmt->execute();
        $stmt->close();
        
        unset($vals);
        unset($args);
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param string $table 表名
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function insert_with_stm($table, $params) {
        $type = '';
        $cols = array();
        $mark = array();
        $vals = array();
        foreach ($params as $key => $item) {
            $type.= $item[0];
            $cols[] = $key;
            $mark[] = '?';
            $vals[] = $item[1];
        }
        
        $_cols = join(',', $cols);
        $_mark = join(',', $mark);
        $stmt = self::call_statement("insert into $table ($_cols) values ($_mark);", $type, $vals);
        $stmt->execute();
        $stmt->close();
        
        unset($cols);
        unset($mark);
        unset($vals);
        unset($args);
    }
    
    /**
     * 使用STM参数方法插入数据
     * @param string $table 表名
     * @param string $where 过滤条件，例 where title=?
     * @param array $params 过滤条件的值，例 info['Title'] = array('s', 'title值')
     */
    public function update_with_stm($table, $where, $params) {
        $type = '';
        $cols = array();
        $vals = array();
        foreach ($params as $key => $item) {
            $type.= $item[0];
            $cols[] = $key;
            $vals[] = $item[1];
        }
        
        $_cols = join('=?,', $cols) . '=?';
        $stmt = self::call_statement("update $table set $_cols $where;", $type, $vals);
        $stmt->execute();
        $stmt->close();
        
        unset($cols);
        unset($vals);
        unset($args);
    }
    
    /**
     * 更新数据
     * @param string $table 表名
     * @param string $set set语句，例 xx='xx',yy='yy'
     * @param string $where 过滤条件，例 where title='title值'
     */
    public function update_with_set($table, $set, $where) {
        parent::query("update $table set $set $where");
    }
    
    /**
     * 获取插入数据的最新主键值
     * @return int
     */
    public function get_last_insert_id() {
        $result = parent::query('select LAST_INSERT_ID();');
        if ($result->num_rows == 0) {
            return 0;
        }
        $row = $result->fetch_row();
        $result->close();
        return intval($row[0]);
    }
    
    /**
     * 调用SQL的Statement
     * @param string $sql
     * @param string $type
     * @param array $vals
     * @return mysqli_stmt
     */
    private function call_statement($sql, $type, $vals) {
        $args = array_merge(array($type), $vals);
        $refs = array();
        foreach ($args as $key => $value) {
            $refs[$key] = & $args[$key];
        }
        $stmt = parent::prepare($sql);
        call_user_func_array(array($stmt, 'bind_param'), $refs);
        return $stmt;
    }
}
