<?php

// 中文
if (mb_check_encoding($file, "GBK")) {
    $file = mb_convert_encoding($file, "UTF-8", "GBK");
}
