rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%
set JAVA_HOME=%ROOT_PATH%\Java\jdk1.7.0_45
set ANT_HOME=%ROOT_PATH%\apache-ant-1.9.4
set NODE_HOME=%ROOT_PATH%\Nodejs
set ANDROID_SDK=%ROOT_PATH%\android_sdk
set GIT_HOME=%ROOT_PATH%\Git
set PHP_HOME=%ROOT_PATH%\php\php5.6
set GOROOT=%ROOT_PATH%\golang\go1.6
set GOPATH=%ROOT_PATH%\golang\gopath

setx JAVA_HOME %JAVA_HOME%
setx ANT_HOME %ANT_HOME%
setx GOROOT %GOROOT%
setx GOPATH %GOPATH%

setx path %GOPATH%\bin;%GOROOT%\bin;%PHP_HOME%;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_SDK%\tools;%ANDROID_SDK%\platform-tools;%JAVA_HOME%\bin;%path%;

pause
