<?php

//主线程
for ($i = 0; $i < 5; $i+= 1) {
    $pid = fork_child('say_hello');
    echo "child:$pid \r\n";
}
exit;

//子线程
function fork_child($func_name) {
    $args = func_get_args();
    
    //去掉函数名,第一个参数
    unset($args[0]);
    $pid = pcntl_fork();
    if ($pid == 0) {
        
        //主线程自调,或退出
        function_exists($func_name) and exit(call_user_func_array($func_name, $args)) or exit(-1);
    } 
    else if ($pid == - 1) {
        
        //pcntl_fork不支持
        die("could not fork");
    } 
    else {
        
        //子线程pid
        return $pid;
    }
}

//测试
function say_hello() {
    sleep(3);
    echo "hello world\r\n";
}

//测试结果
// // 主线程先跑完.
// child:27932 
// child:27933 
// child:27934 
// child:27935 
// child:27936 
// //子线程跟着输出.
// dev@ubuntu234:/var/www/kitchen/dev_api/Sites/Crond$ hello world
// hello world
// hello world
// hello world
// hello world
