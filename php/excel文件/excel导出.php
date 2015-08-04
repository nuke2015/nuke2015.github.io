<?php

excel_export();

/**
 * excel导出;
 * @return [type] [description]
 */
public function excel_export() {
    if (isset($_SESSION['traffic_where'])) {
        $where = $_SESSION['traffic_where'];
    } else {
        $where = 'where 1';
    }
    include ('model/adv/traffic.php');
    $traffic_model = new traffic_model();
    $list = $traffic_model->get_list($where);
    $list = $this->format($list);
    $date = date("Y_m_d_H_i_s");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=choujiang{$date}.xls");
    $this->assign('list', $list);
    $this->display('excel.tpl');
}

//输出的直接是
// <table>
//     <tr>
//         <td></td>
//     </tr>
// </table>
// 类似的表格


