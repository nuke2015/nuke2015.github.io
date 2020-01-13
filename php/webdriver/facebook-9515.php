<?php

namespace Facebook\WebDriver;




use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;


// This is where ChromeDriver is listening
$host = "http://127.0.0.1:9515";
$capabilities =  DesiredCapabilities::chrome();

$capabilities->setCapability("chromeOptions", array(
    "args" => array(
        "--window-size=1366,768",
        "--no-proxy-server",
        "--no-default-browser-check",
        "--no-first-run",
        "--disable-boot-animation",
        "--disable-default-apps",
        "--disable-extensions",
        "--disable-translate"
    ),
));

$driver = RemoteWebDriver::create($host, $capabilities);


$driver->get('https://so.bestphp.net/');
$driver->findElement(WebDriverBy::id('kw'))->sendKeys('测试')->submit();

// 等待新的页面加载完成....
$waitSeconds = 1;
$driver->wait($waitSeconds)->until(
    WebDriverExpectedCondition::visibilityOfElementLocated(
        WebDriverBy::id('content_left')
    )
);
$arr = $driver->findElement(WebDriverBy::cssSelector('#content_left'))->findElements(WebDriverBy::cssSelector('a'));
if ($arr && count($arr)) {
    foreach ($arr as $key => $value) {
        $title = $value->getText();
        var_dump($key, $title);
    }
}
//关闭浏览器
$driver->quit(); 
