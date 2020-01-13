<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;

// https://www.kancloud.cn/wangking/selenium/234398

// $host = 'http://localhost:4444/wd/hub'; 
// header("Content-Type: text/html; charset=UTF-8");

$capabilities = DesiredCapabilities::chrome();
$useragent = 'chrome';
$options = new ChromeOptions();
$options->addArguments(["user-agent={$useragent}", "no-sandbox","handless", "blink-settings=imagesEnabled=false", "disable-dev-shm-usage", "disable-accelerated-2d-canvas", "--disable-gpu", "disable-setuid-sandbox"]);
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($host, $capabilities, 5000);

$driver->get('https://so.bestphp.com/');
$driver->findElement(WebDriverBy::id('kw'))->sendKeys('测试')->submit();

// 等待新的页面加载完成....
$waitSeconds = 1;  
$driver->wait($waitSeconds)->until(
    WebDriverExpectedCondition::visibilityOfElementLocated(
        WebDriverBy::id('content_left')
    )
);
$arr = $driver->findElement(WebDriverBy::cssSelector('#content_left'))->findElements(WebDriverBy::cssSelector('a'));
if($arr && count($arr)){
    foreach ($arr as $key => $value) {
        $title=$value->getText();
        var_dump($key,$title);
    }
}
//关闭浏览器
$driver->quit(); 
