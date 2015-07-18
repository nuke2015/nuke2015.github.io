<?php
$name = 'AppPromoZhongQiu2014ActiveStatusSelector';

echo cc_format($name);
function cc_format($name) {
    $temp_array = array();
    for ($i = 0;$i < strlen($name);$i++) {
        $ascii_code = ord($name[$i]);
        if ($ascii_code >= 65 && $ascii_code <= 90) {
            if ($i == 0) {
                $temp_array[] = chr($ascii_code + 32);
            } else {
                $temp_array[] = '_' . chr($ascii_code + 32);
            }
        } else {
            $temp_array[] = $name[$i];
        }
    }
    return implode('', $temp_array);
}
