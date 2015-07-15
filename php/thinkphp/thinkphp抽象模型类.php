
thinkphp支持自定义抽象类.
1.在model下面新建
FsModel.class.php
<?php
class FsModel {
    public function test(){
        echo 'test';
    }
}
?>

2.在model/home/下面新建
AbcModel.class.php
<?php
class AbcModel extends FsModel {
}
?>

3.在action/home/IndexAction.class.php
可以直接初始化abc类,并调用FsModel中的扩展方法.
此处不能用M();
$Abc=D('Abc');
$Abc->test();
exit;
