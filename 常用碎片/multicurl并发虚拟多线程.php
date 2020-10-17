<?php
#选项;
function setChOption( $ch , $url ){
    curl_setopt($ch , CURLOPT_URL , $url);
    curl_setopt($ch , CURLOPT_HEADER , 0);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($ch , CURLOPT_USERAGENT , 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');
}
#并发;
function multiCurl( $urls ){
    // 创建批处理cURL句柄
    $mh = curl_multi_init();
    $chArray = array( );
    foreach ( $urls as $url ) {
		$ch = curl_init();
		setChOption($ch,$url);
		$chArray[ ] = $ch;
		curl_multi_add_handle($mh,$ch);
    }
    $running = null;
    // 执行批处理句柄
    do {
		curl_multi_exec($mh,$running);
    }while( $running > 0);

    $return = array( );
    foreach ( $chArray as $ch ) {
		$return[ ] = curl_multi_getcontent($ch);
		curl_multi_remove_handle($mh , $ch); //移除句柄,回收内存;
    }

	// 关闭全部句柄
    curl_multi_close($mh);
    return $return;
}

$productsUrl[]='http://www.baidu.com';
$productsUrl[]='http://www.sina.com';
$productsUrl[]='http://www.163.com';
$productsUrl[]='http://www.alipay.com';

$tmp[] = multiCurl($productsUrl);

echo '<pre>'.print_r($tmp).'</pre>';