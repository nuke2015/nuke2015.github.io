<?php
namespace home;
require_once __DIR__ . '/base.php';
class base extends \base
{
    public function __construct() {
        echo 'home\base<br/>';
        parent::__construct();
    }
}
