<?php
class MonitorDao extends MongoBase
{
    
    public function __construct($cname='jiankong') {
        $this->CollectionName = $cname;
        parent::__construct('boss',$cname);
    }

    public function collection(){
        return $this->_collection;
    }
}
