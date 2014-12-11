<?php

echo '<pre>';


$info = array('D:\AMP\bin\php\\fslog.php', 'D:\mysvn', '29', '28-s');
if($info){
    $svn=$info[1];
    $version=$info[2];
    exec('D:\advance\SlikSvn\bin\svnlook changed d:/mysvn -r 29',$changes);
    if($changes){
        foreach($changes as $item){
            $tmp=explode('   ',trim($item));
            $tasks[]=$tmp;
        }
    }
}
print_r($tasks);



