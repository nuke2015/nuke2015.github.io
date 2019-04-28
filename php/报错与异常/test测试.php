<?php

/**
 * 异常或错误的handler与error_reporting设置无关.
 * error_reporting只设置是否在页面上直接显示错误.
 * handler函数会重载内置的错误或异常处理逻辑.
 * 用户抛异常会中断代码运行.
 * 用户抛错误不会中断代码运行.
 *
 */

// error_reporting(2047);
error_reporting(0);
echo 'testing...';
function my_error_handler($errno, $errstr, $errfile, $errline) {
    echo '<hr/>error<br/>';
    echo $errstr;
    echo '<br/>';
}
function my_exception_handler($error) {
    echo '<hr/>excep<br/>';
    echo $error;
    echo '<br/>';
}
function my_shutdown_function() {
    echo '<hr/>shut<br/>';
    echo '<br/>';
}
set_error_handler('my_error_handler');
set_exception_handler('my_exception_handler');
register_shutdown_function('my_shutdown_function');

//error,内置错误
$variable = 1;
foreach ($variable as $key => $value) {
}

//user error,用户抛错误
trigger_error('hello user Error');

//user exception,用户抛异常
throw new Exception('hello user Exception');

// 测试结果
// testing...
// error
// Invalid argument supplied for foreach()
// error
// hello user Error
// excep
// exception 'Exception' with message 'hello user Exception' in F:\svn_kitchen\dev_api\Sites\Web\index.php:40 Stack trace: #0 {main}
// shut

exit;
