<?php

/**
 * php-fpm中即使禁用了pcntl相关的函数.
 * 在php-cli中也可以正常使用.
 * 因为php-cli与php-fpm使用的是不同php.ini配置
 *
 */
if (function_exists('pcntl_fork')) {
    echo 'fork';
} 
else {
    echo 'safe';
}
echo "\r\n";
exit;
