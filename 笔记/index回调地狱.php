<?php
error_reporting(2047);

$db = '';
$db = new DB($_CFG['database_back']['host'], $_CFG['database_back']['root'], $_CFG['database_back']['password'], 'to8to');
$db->SetTablePre('to8to_');
$db->SetCharset('utf8');
$db->close_slaver();
set_time_limit(0);
ini_set('memory_limit', '1024M');
ob_end_clean();
ob_implicit_flush(true);

// $db->SetPrintSql(true);

$zhishi = new zhishi();
$zhishi->init($db);

echo 'done!';
exit;

class zhishi
{
    
    //装修知识修复;
    function init($db) {
        $this->db = $db;
        $sql = "SELECT count(kid) as count FROM `to8to_knowzxcs` ";
        $res = $this->db->FetchRow($sql);
        if ($res) {
            $this->count($res[0]['count']);
        }
    }
    
    //知识循环
    function count($count) {
        $step = 100;
        for ($i = 0; $i < $count; $i+= $step) {
            $sql = "SELECT kid,content,content_app FROM `to8to_knowzxcs` where 1 ORDER BY `kid`  limit {$i},{$step}  ";
            $res = $this->db->FetchRow($sql);
            if ($res) {
                $this->res($res);
            }
        }
    }
    
    //知识一批
    function res($res) {
        foreach ($res as $item) {
            if ($item['content_app']) continue;
            $this->format($item);
        }
    }
    
    //格式化;
    function format($data) {
        require_once ('../../gb_php/AppHomeDetailFormat.class.php');
        $AppHomeDetailFormat = new AppHomeDetailFormat();
        $data['content_app'] = $AppHomeDetailFormat->format_know($data['content']);
        $this->update($data);
        exit;
    }
    
    //新知识入库
    function update($data) {
        $data['content_app'] = daddslashes(SafeHtml($data['content_app']));
        $sql = "UPDATE `to8to_knowzxcs` SET `content_app` = '{$data['content_app']}' WHERE `kid` = '{$data['kid']}'  ";
        print_r($sql);
        if ($data['content_app']) {
            $res = $this->db->ExeSql($sql);
        }
    }
}
