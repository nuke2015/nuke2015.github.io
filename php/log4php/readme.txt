log4php配置文档

下载
http://apache.fayea.com/logging/log4php/2.3.0/apache-log4php-2.3.0-src.tar.gz

解压
取/src/main/php改为log4php放在根目录

编辑index.php
<?php

// Insert the path where you unpacked log4php
include('log4php/Logger.php');
 
// Tell log4php to use our configuration file.
Logger::configure('config.xml');
 
// Fetch a logger, it will inherit settings from the root logger
$log = Logger::getLogger('myLogger');
 
// Start logging
$log->trace("My first message.");   // Not logged because TRACE < WARN
$log->debug("My second message.");  // Not logged because DEBUG < WARN
$log->info("My third message.");    // Not logged because INFO < WARN
$log->warn("My fourth message.");   // Logged because WARN >= WARN
$log->error("My fifth message.");   // Logged because ERROR >= WARN
$log->fatal("My sixth message.");   // Logged because FATAL >= WARN





编辑config.xml
<configuration xmlns="http://logging.apache.org/log4php/">
    <appender name="myAppender" class="LoggerAppenderFile">
        <param name="file" value="myLog.log" />
    </appender>
    <root>
        <level value="WARN" />
        <appender_ref ref="myAppender" />
    </root>
</configuration>





访问
会生成日志文件myLog.log

