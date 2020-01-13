<?php

namespace Facebook\WebDriver;




use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;

// https://www.kancloud.cn/wangking/selenium/234398

// 甚好.
putenv('webdriver.chrome.driver=D:/advance/sbin/chromedriver.exe');
$driver = ChromeDriver::start();


$driver->get('https://so.bestphp.com/');
$driver->findElement(WebDriverBy::id('kw'))->sendKeys('新闻')->submit();

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
