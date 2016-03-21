<?php

// 对于部分远程调用失败以后,只重试一次!

test::main();

class test
{
    private static $retry = 0;

    // 子调用
    private static function hello()
    {
        // 模拟环境干扰
        $rand = rand(0, 1);
        if ($rand) {
            echo 'hello<br/>';
            return true;
        } else {
            echo 'error<br/>';
            return false;
        }
    }

    public static function main()
    {
        while (!$status = self::hello()) {
            self::$retry += 1;
            if (self::$retry > 10) {
                break;
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
