<?php
class base
{
    public function __construct() {
        echo 'base\base<br/>';
    }
    public function test() {
        echo get_class($this);
        echo "<br/>";
    }
}
