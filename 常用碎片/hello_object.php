<?php
class hello {
    public $title = "hello";
    public static $title_static = "hello static";
    const title_const = "hello const";
    public function greep() {
        return $this->title;
    }
    
    public static function greep_static() {
        return self::$title_static;
    }
    
    public static function greep_const() {
        return self::title_const;
    }
}

echo "<br/>";
$hello = new hello();
$greep = $hello->greep();
var_dump($greep);
echo "<br/>";
$greep_static = hello::greep_static();
var_dump($greep_static);
echo "<br/>";
$greep_const = hello::greep_const();
var_dump($greep_const);

// // 运行结果
// string(5) "hello"
// string(12) "hello static"
// string(11) "hello const"
