rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%
set JAVA_HOME=%ROOT_PATH%\Java\jdk
set ANT_HOME=%ROOT_PATH%\ant
set NODE_HOME=%ROOT_PATH%\Nodejs
set ANDROID_HOME=%ROOT_PATH%\Nodejs
set ANDROID_HOME=%ROOT_PATH%\ANDROID_HOME
set GIT_HOME=%ROOT_PATH%\Git
set PHP_HOME=%ROOT_PATH%\php\php
set GOROOT=%ROOT_PATH%\go
set GOPATH=D:\gopath
set FASTBOOT_PATH=%ROOT_PATH%\fastboot\
set CHROME_PATH=D:\soft\chrome\
set PHANTOMJS=%ROOT_PATH%\phantomjs
set SVN_PATH=%ROOT_PATH%\Apache-Subversion

setx JAVA_HOME %JAVA_HOME%
setx ANT_HOME %ANT_HOME%
setx GOROOT %GOROOT%
setx GOPATH %GOPATH%

setx path %ROOT_PATH%\sbin;%PHANTOMJS%\bin;%GOPATH%\bin;%GOROOT%\bin;%PHP_HOME%;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_HOME%\tools;%ANDROID_HOME%\platform-tools;%JAVA_HOME%\bin;%FASTBOOT_PATH%;%CHROME_PATH%;%SVN_PATH%\bin;%path%;

pause
