<?php
class homepage_bannerModel extends Model
{
    
    //这里可以自定义表名,然后数据库表名与上面的模型名,自然就解耦了!
    //比如数据库表名叫homepage_banner,模型名可以叫home或homepage或其它任意.
    public $trueTableName = 'homepage_banner';
    
    public function info() {
        $result = array();
        return $result;
    }
}
