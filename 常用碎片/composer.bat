rem curl -sS https://getcomposer.org/installer | php
php -r "readfile('https://getcomposer.org/installer');" | php
@php "%~dp0composer.phar" %*
