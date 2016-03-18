@echo off
rem curl -sS https://getcomposer.org/installer | php
rem php -r "readfile('https://getcomposer.org/installer');" | php
@php "%~dp0composer.phar" %*
