<?php 
spl_autoload_register(function ($class) {
    // 命名空间前缀的基目录
    $file = __DIR__ .'/'. $class.'.class.php';
    // 如果以上文件存在，则将其载入
    if (file_exists($file)) {
        require_once $file;
    }
});

