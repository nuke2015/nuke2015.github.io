<?php

// 空间别名
spl_autoload_register(function ($class_name) {
    if (stripos($class_name, 'didiyuesao\api\base') !== false) {
        // 只引base项目,其它不动!
        $map = str_ireplace('didiyuesao\api\base', 'nuke2015\api\base', $class_name);
        class_alias($map, $class_name);
    }
});
