<?php
echo '<pre>';

for ($i = 1; $i < 33; $i++) {
    $changes=array();
    exec('D:\advance\SlikSvn\bin\svnlook changed d:/mysvn -r '.$i, $changes);
    // print_r($changes);
    if($changes){
        foreach ($changes as $value) {
            $value=trim($value);
            $tmp=explode('   ', $value);
            if($tmp)$result[]=$tmp;
        }
    }
}

print_r($result);


