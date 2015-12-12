<?php
class UserModel extends RelationModel
{
    protected $_link = array(
        'Article' => array('mapping_type' => HAS_MANY, 'class_name' => 'Article', 'foreign_key' => 'userid', 'mapping_name' => 'articles', 'mapping_order' => 'createtime desc', 'mapping_limit' => '0,5','mapping_fields'=>'title,description')
        );
    
    public function hello() {
        echo 'hello user';
    }
}
