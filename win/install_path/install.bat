rem 一键安装java,ant,android,nodejs

set ROOT_PATH=%CD%
set JAVA_HOME=%ROOT_PATH%\jdk1.8.0_20
set ANT_HOME=%ROOT_PATH%\apache-ant-1.9.4
set NODE_HOME=%ROOT_PATH%\Nodejs
set MAVEN_HOME=%ROOT_PATH%\apache-maven-3.2.3
set GIT_HOME=%ROOT_PATH%\Git
set ANDROID_SDK=%ROOT_PATH%\Android\sdk
set GOROOT=%ROOT_PATH%\go
set GOPATH=D:\MYDOC\GOPATH
set MINGW=%ROOT_PATH%\mingw
set PHPROOT=%ROOT_PATH%\php5.4

setx JAVA_HOME %JAVA_HOME%
setx ANT_HOME %ANT_HOME%
setx GOROOT %GOROOT%
setx GOPATH %GOPATH%

setx path  %MINGW%\bin;%GOROOT%\bin;%GIT_HOME%\bin;%NODE_HOME%;%NODE_HOME%\node_modules\.bin;%ANT_HOME%\bin;%ANDROID_SDK%\tools;%ANDROID_SDK%\platform-tools;%JAVA_HOME%\bin;%MAVEN_HOME%\bin;%PHPROOT%;%path%;
pause
