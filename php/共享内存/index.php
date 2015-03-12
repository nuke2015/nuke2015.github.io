<?php

error_reporting(2047);

//extension=php_shmop.dll

include 'Block.php';

for($i=0;$i<1000;$i++){
    $Block=new Block($i);
    $data="fengTest".rand(0,10000);
    $Block->write($data);
    dump($data);

    $read=$Block->read();
    dump($read);
    echo '<hr>';
}


function dump($v){
    print_r($v);
    echo '<br>';
}

