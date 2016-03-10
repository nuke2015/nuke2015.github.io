<?php

$url  = 'http://video.szzhangchu.com/gaogainaiyansudabingganA.mp4';
$file = "test.mp4";
Fio::stream_to_stream($url, $file);

echo 'done!';

class Fio
{

    // 外封装
    public static function stream_to_stream($url, $file)
    {
        self::pipe_streams(fopen($url, 'r'), fopen($file, 'w'));
    }

    // io流
    public static function pipe_streams($in, $out)
    {
        $size = 0;
        while (!feof($in)) {
            $size += fwrite($out, fread($in, 8192));
        }
        return $size;
    }
}
