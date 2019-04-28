<?php
namespace app\index\controller;

use think\Log;

class Index
{
    public function index()
    {
        Log::init(['type' => 'File', 'path' => RUNTIME_PATH . '/Logs/']);
        Log::error('错误信息');
        Log::info('日志信息');

        // 和下面的用法等效
        Log::record('错误信息', 'error');
        Log::record('日志信息', 'info');

        trace('错误信息', 'error');
        trace('日志信息', 'info');
    }
}
