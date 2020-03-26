rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%
set REDIS_HOME=%CD%\redis
set JAVA_HOME=%ROOT_PATH%\Java\jdk1.7.0_45
set ANT_HOME=%ROOT_PATH%\apache-ant-1.9.4
set PHP_HOME=%ROOT_PATH%\php-cli
set GIT_HOME=%ROOT_PATH%\Git
set NODE_HOME=%ROOT_PATH%\Nodejs
set ANDROID_HOME=%ROOT_PATH%\ANDROID_HOME
set GIT_HOME=%ROOT_PATH%\Git
set GOROOT=%ROOT_PATH%\go
set GOPATH=D:\gopath
set FASTBOOT_PATH=%ROOT_PATH%\fastboot\
set CHROME_PATH=D:\soft\chrome\
set CYGWIN64_PATH=%ROOT_PATH%\cygwin64\
set PHANTOMJS=%ROOT_PATH%\phantomjs
set SVN_PATH=%ROOT_PATH%\Apache-Subversion

setx JAVA_HOME %JAVA_HOME%
setx GRADLE_HOME %ROOT_PATH%\gradle
setx ANT_HOME %ANT_HOME%
setx GOROOT %GOROOT%
setx GOPATH %GOPATH%

setx path D:\git\composer\vendor\bin\;%CYGWIN64_PATH%\bin;%ROOT_PATH%\sbin;%GRADLE_HOME\bin%;%REDIS_HOME%;%PHANTOMJS%\bin;%GOPATH%\bin;%GOROOT%\bin;%PHP_HOME%;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_HOME%\tools;%ANDROID_HOME%\platform-tools;%JAVA_HOME%\bin;%FASTBOOT_PATH%;%CHROME_PATH%;%SVN_PATH%\bin;%path%;

pause
