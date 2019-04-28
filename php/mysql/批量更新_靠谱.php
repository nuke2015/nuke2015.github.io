<?php
// replace into dishes (dishes_id,collect_count) values (252,2),(255,3);
// 主键对应收藏数
$data = array(
    258 => 2,
    263 => 1,
    274 => 9,
);

//组装批量更新语句
function update_batch($table, $pkey, $field, $data)
{
    $sql = '';
    if ($data && count($data)) {

        $ids = implode(',', array_keys($data));
        $sql = "UPDATE {$table} SET {$field} = CASE {$pkey} ";
        foreach ($data as $id => $value) {
            $sql .= sprintf("WHEN %d THEN %d ", $id, $value);
        }
        $sql .= "END WHERE {$pkey} IN ($ids)";
    }
    return $sql;
}

$sql = update_batch('dishes', 'dishes_id', 'collect_count', $data);

echo $sql;
