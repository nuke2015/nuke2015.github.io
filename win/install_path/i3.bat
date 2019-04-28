rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%

rem nodejs
set NODE_HOME=%ROOT_PATH%\Nodejs

rem android
set ANDROID_SDK=%ROOT_PATH%\Android\sdk

rem php
set PHP_HOME=%ROOT_PATH%\php5.6

rem git
set GIT_HOME=%ROOT_PATH%\git\

rem java
set JAVA_HOME=%ROOT_PATH%\Java\jdk1.7.0_45
set ANT_HOME=%ROOT_PATH%\apache-ant-1.9.4
setx JAVA_HOME %JAVA_HOME%
setx ANT_HOME %ANT_HOME%

rem golang
set GOROOT=%ROOT_PATH%\go\golang\
setx GOROOT %GOROOT%
set GOPATH=%ROOT_PATH%\go\gopath\
setx GOPATH %GOPATH%

setx path %NODE_HOME%;%GOROOT%\bin;%GOPATH%\bin;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_SDK%\tools;%ANDROID_SDK%\platform-tools;%JAVA_HOME%\bin;%PHP_HOME%\;%GIT_HOME%\bin;%path%;

pause
