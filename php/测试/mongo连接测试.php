<?php
header("Content-type: text/html;charset=utf-8");

$mongo = new MongoClient($server = 'mongodb://127.0.0.1:27017');
var_dump($mongo);

$admin = new admin($mongo);
$dbs = $admin->listdbs();
dump($dbs);
exit;

class admin
{
    
    public function __construct($mongo) {
        $this->mongo = $mongo;
    }
    
    /**
     * 数据库列表
     * Array
     *(
     *    [name] => livedecoration
     *    [sizeOnDisk] => 486539264
     *    [empty] =>
     *)
     * @return array 数组
     */
    public function listdbs() {
        $dbs = $this->mongo->listDBS();
        if ($dbs['ok']) {
            return $dbs['databases'];
        } else {
            return array();
        }
    }
    
    /**
     * 表格输出
     * 输出前需要自己控制单元格数据;
     * @return [type] [description]
     */
    public function table($data) {
    }
}

//变量查看;
function dump($v) {
    echo '<pre>';
    print_r($v);
    echo '</pre>';
}
