1.在lib下新建Service文件夹
2.在lib/Service下新建AbcService.class.php
<?php
class AbcService{
}
?>
3.在lib/Home/IndexAction.class.php下调用
import("@.Service.AbcService");
$AbcService=new AbcService();
var_dump($AbcService);
exit;
