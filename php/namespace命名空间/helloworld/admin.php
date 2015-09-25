<?php
namespace admin;
require_once __DIR__ . '/base.php';
class base extends \base
{
    public function __construct() {
        echo 'admin\base<br/>';
        parent::__construct();
    }
}
