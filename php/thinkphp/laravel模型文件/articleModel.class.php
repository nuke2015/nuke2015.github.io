<?php

require './LaravelModel.class.php';
class articleModel extends LaravelModel
{
    protected $table = 'article';
    public $timestamps = false;
    
    //范围查询 
    public function scopeWomen($query) {
        return $query->where('id', '>', 0);
    }
}
