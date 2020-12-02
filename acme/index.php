<?php
// 拿到用户号id,返回的时候,参数.用户
// root@ed:~# acme.sh --register-account
// [Mon Feb  6 21:40:18 CST 2017] Registering account
// [Mon Feb  6 21:40:19 CST 2017] Already registered
// [Mon Feb  6 21:40:21 CST 2017] Update success.
// [Mon Feb  6 21:40:21 CST 2017] ACCOUNT_THUMBPRINT='6fXAG9VyG0IahirPEU2ZerUtItW2DHzDzD9wZaEKpqd'
// 原理
// http {
// ...
// server {
// ...
//   location ~ ^/\.well-known/acme-challenge/([-_a-zA-Z0-9]+)$ {
//     default_type text/plain;
//     return 200 "$1.6fXAG9VyG0IahirPEU2ZerUtItW2DHzDzD9wZaEKpqd";
//   }
// ...
// }
// }
// 注册
// acme.sh --issue -d example.com  --stateless

$s = (isset($_REQUEST['s'])) ? $_REQUEST['s'] : '';
if (stripos($s, '.well-known/acme-challenge/') !== false) {
    preg_match('@acme-challenge\/(.*)$@isU',$s, $tmp);
    $s=trim($tmp[1]);
    echo "$s.x8_HqnBGBfGEIQGbyA2qWLsjxQLHeDF2mNynjsC7Kp4";
} else {
    echo 'well-known ok,but 404la!';
}
