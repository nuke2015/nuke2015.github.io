<?php

// // 关联模板查询
// $R_commentModel = D('R_comment');
// $data = $R_commentModel->relation(true)->order('id DESC')->limit(0,10)->select();
// print_r($data);
// exit;
       
        
class R_commentModel extends RelationModel{
    Protected $tableName='comment';
    protected $_link = array(
         'parents' =>array(
            'class_name'=>'R_comment',
            'mapping_type'=>BELONGS_TO,
            'parent_key'=>'parent_id',
        ),
    );
 }

