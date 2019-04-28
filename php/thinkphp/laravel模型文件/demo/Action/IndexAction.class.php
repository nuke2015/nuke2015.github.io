<?php

// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action
{
    
    // 所有数据
    public function index() {
        $articles = articleModel::all();
        foreach ($articles as $article) {
            print_r($article->title);
            echo '<br/>';
        }
        exit;
    }
    
    // 范围查询
    public function scope() {
        $articles = articleModel::women()->orderBy('created_at')->get();
        foreach ($articles as $article) {
            print_r($article->title);
            echo '<br/>';
        }
        exit;
    }
    
    // 摸一下
    public function touch() {
        $article = articleModel::find(1);
        $affectedRows = $article->touch();
        var_dump($affectedRows);
        exit;
    }
    
    // 条件删除
    public function delete() {
        $affectedRows = articleModel::where('id', '>', 3)->delete();
        var_dump($affectedRows);
        exit;
    }
    
    // 条件更新
    public function update() {
        $affectedRows = articleModel::where('id', '>', 0)->update(array('view' => '1'));
        var_dump($affectedRows);
        exit;
    }
    
    // 添加数据
    public function add() {
        $articleModel = new articleModel;
        $articleModel->title = 'John';
        $articleModel->content = '测试测试';
        $do = $articleModel->save();
        var_dump($do);
    }
    
    // whererow+bind
    public function whererow() {
        $articles = articleModel::whereRaw('id > ? and id < ?', array(0, 10))->get();
        foreach ($articles as $article) {
            print_r($article->title);
            echo '<br/>';
        }
        exit;
    }
    
    // where+limit
    public function where() {
        $articles = articleModel::where('id', '>', 0)->take(10)->get();
        foreach ($articles as $article) {
            print_r($article->title);
            echo '<br/>';
        }
        exit;
    }
    
    // 根据id取一条
    public function find() {
        $article = articleModel::find(1);
        print_r($article->title);
        exit;
    }
    
    // 所有数据
    public function all() {
        $articles = articleModel::all();
        foreach ($articles as $article) {
            print_r($article->title);
            echo '<br/>';
        }
        exit;
    }
    
    // 单条
    public function first() {
        $article = articleModel::first();
        print_r($article->title);
        echo '<br/>';
        print_r($article->content);
        exit;
    }
}
