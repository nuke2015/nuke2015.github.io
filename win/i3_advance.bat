rem 一键安装java,ant,android,nodejs

set ROOT_PATH=D:\advance
set JAVA_HOME=%ROOT_PATH%\Java\jdk
set PYTHON_HOME=%ROOT_PATH%\python
set NODE_HOME=%ROOT_PATH%\Nodejs
set GIT_HOME=%ROOT_PATH%\Git
set PHP_HOME=%ROOT_PATH%\php\php
set GOROOT=%ROOT_PATH%\go
set GOPATH=D:\gopath
set CHROME_PATH=D:\working\chrome\
set COMPOSER_PATH=D:\git\composer\vendor\

setx JAVA_HOME %JAVA_HOME%
setx ANT_HOME %ANT_HOME%
setx ANDROID_HOME %ANDROID_HOME%
setx GOROOT %GOROOT%
setx GOPATH %GOPATH%

rem goproxy
setx GOPROXY "https://mirrors.aliyun.com/goproxy/"
setx GO111MODULE on 

setx path "%ROOT_PATH%\cygwin\bin;%ROOT_PATH%\pyenv-win\bin\;%COMPOSER_PATH%\bin;%ROOT_PATH%\sbin;%PHANTOMJS%\bin;%GOPATH%\bin;%GOROOT%\bin;%PHP_HOME%;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_HOME%\tools;%ANDROID_HOME%\platform-tools;%JAVA_HOME%\bin;%FASTBOOT_PATH%;%CHROME_PATH%;%PYTHON_HOME%;%PYTHON_HOME%\Scripts;%path%";
@echo %path%;
pause
