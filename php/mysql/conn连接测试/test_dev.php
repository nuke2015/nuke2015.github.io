<?php

$db = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', 'root');

try {

    foreach ($db->query('select * from user') as $row) {

        print_r($row);

    }

    $db = null; //关闭数据库

} catch (PDOException $e) {

    echo $e->getMessage();

}
