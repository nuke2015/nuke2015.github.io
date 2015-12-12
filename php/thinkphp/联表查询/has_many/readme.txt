<?php 
    
    //关联查询
    $UserModel=D('User');
    $data= $UserModel->relation(true)->find(1);
    echo $UserModel->getLastsql();
    print_r($data);
    exit;


    说明:
    用户表user存的是用户
    文章表article存的是文章
    一个用户有多篇文章
    定制关联类型

    //关联定义
    protected $_link = array(
        'Article' => array('mapping_type' => HAS_MANY, 'class_name' => 'Article', 'foreign_key' => 'userid', 'mapping_name' => 'articles', 'mapping_order' => 'createtime desc', 'mapping_limit' => '0,5','mapping_fields'=>'title,description')
        );

    //注意事项:
    在测试的时候,要先判断类是否加载,只有D()加载的类才是定制类,M()的类是虚拟类,定制不会生效.

    
    