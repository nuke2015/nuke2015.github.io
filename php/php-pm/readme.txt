
依赖
composer install php-pm/php-pm

安装ppm
git clone https://github.com/php-pm/php-pm.git
cd php-pm
composer install
ln -s `pwd`/bin/ppm /usr/local/bin/ppm
ppm --help

安装后,依赖php7.0/cli/PCNTL扩展才能运行


