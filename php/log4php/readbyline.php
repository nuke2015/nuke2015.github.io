<?php
$handle = @fopen("nginx.log", "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = trim(fgets($handle));
        if ($buffer) {
            do_line($buffer);

        }
    }
    fclose($handle);
}
echo 'done!';

function do_line($line)
{
    $data = json_decode($line, 1);
    if ($data && count($data)) {
        foreach ($data as $key => $value) {
            if ($value['link']) {
                file_put_contents('links.txt', $value['link'] . "\r\n", FILE_APPEND);
            }
        }
    }
}
