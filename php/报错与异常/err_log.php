<?php
use didiyuesao\api\org;

// 全捕捉
define('E_FATAL', E_ERROR | E_USER_ERROR | E_CORE_ERROR |
    E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE);

// 未端勾子
register_shutdown_function('fatal_handler');

// 常规捕捉
set_error_handler('error_handler');

// 获取fatal error
function fatal_handler()
{
    // 未端勾子
    $error = error_get_last();
    // 识别目标错误类型
    if ($error && ($error["type"] === ($error["type"] & E_FATAL))) {
        error_handler($error["type"], $error["message"], $error["file"], $error["line"]);
    }
}

// 获取所有的error
function error_handler($errno, $errstr, $errfile, $errline)
{
    $e = ['code' => $errno, 'msg' => $errstr, 'file' => $errfile, 'line' => $errline];
    org\Flogger::plog('error_think', $e);
}
