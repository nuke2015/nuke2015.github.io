<?php

// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action
{
    public function index() {
        $article = articleModel::first();
        print_r($article->title);
        echo '<br/>';
        print_r($article->content);
        exit;
    }
}
