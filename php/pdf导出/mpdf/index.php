<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

// 支持中文
$mpdf->useAdobeCJK = true;
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;

$mpdf->WriteHTML('<h1>Hello world!这是一个神奇的工具</h1>');
$mpdf->Output();
