rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%
set JAVA_HOME=%ROOT_PATH%\Java\jdk
set ANT_HOME=%ROOT_PATH%\ant
set PYTHON_HOME=%ROOT_PATH%\python
set PYENV_HOME=%ROOT_PATH%\pyenv
set NODE_HOME=%ROOT_PATH%\Nodejs
set ANDROID_HOME=%ROOT_PATH%\ANDROID_HOME
set GIT_HOME=%ROOT_PATH%\Git
set PHP_HOME=%ROOT_PATH%\php\php
set MINGW_HOME=%ROOT_PATH%\mingw
set CYGWIN_HOME=%ROOT_PATH%\cygwin
set GOROOT=%ROOT_PATH%\go
set FASTBOOT_PATH=%ROOT_PATH%\fastboot\
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

setx path %PYENV_HOME%\pyenv-win\bin\;%CYGWIN_HOME%\bin;%MINGW_HOME%\bin;%COMPOSER_PATH%\bin;%ROOT_PATH%\sbin;%PHANTOMJS%\bin;%GOPATH%\bin;%GOROOT%\bin;%PHP_HOME%;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_HOME%\tools;%ANDROID_HOME%\platform-tools;%JAVA_HOME%\bin;%FASTBOOT_PATH%;%CHROME_PATH%;%PYTHON_HOME%;%PYTHON_HOME%/Scripts;%path%;

pause
