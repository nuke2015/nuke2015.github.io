<?php

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379?auth=123456');

session_start();
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;

echo $count;

$_SESSION['count'] = ++$count;
