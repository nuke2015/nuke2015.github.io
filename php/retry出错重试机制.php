<?php

// 对于部分远程调用失败以后,只重试一次!

test::hello();

class test {
    private static $retry = 0;
    public static function hello() {
        echo '<br/>';
        $rand = rand(0, 1);
        self::$retry+= 1;
        if ($rand) {
            echo 'hello';
        } else {
            echo 'error';
            
            //出错才重试一次;
            if (self::$retry == 1) {
                self::hello();
            }
        }
    }
}


// 正常结果:
// hello

// 重试后正常:
// error
// hello

// 重试一次也不正常:
// error
// error
