<?php
#ѡ��;
function setChOption( $ch , $url ){
    curl_setopt($ch , CURLOPT_URL , $url);
    curl_setopt($ch , CURLOPT_HEADER , 0);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($ch , CURLOPT_USERAGENT , 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');
}
#����;
function multiCurl( $urls ){
    // ����������cURL���
    $mh = curl_multi_init();
    $chArray = array( );
    foreach ( $urls as $url ) {
		$ch = curl_init();
		setChOption($ch,$url);
		$chArray[ ] = $ch;
		curl_multi_add_handle($mh,$ch);
    }
    $running = null;
    // ִ����������
    do {
		curl_multi_exec($mh,$running);
    }while( $running > 0);

    $return = array( );
    foreach ( $chArray as $ch ) {
		$return[ ] = curl_multi_getcontent($ch);
		curl_multi_remove_handle($mh , $ch); //�Ƴ����,�����ڴ�;
    }

	// �ر�ȫ�����
    curl_multi_close($mh);
    return $return;
}

$productsUrl[]='http://www.baidu.com';
$productsUrl[]='http://www.sina.com';
$productsUrl[]='http://www.163.com';
$productsUrl[]='http://www.alipay.com';

$tmp[] = multiCurl($productsUrl);

echo '<pre>'.print_r($tmp).'</pre>';