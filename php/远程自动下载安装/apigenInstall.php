#!/usr/bin/env php
<?php


set_error_handler(
    function ($code, $message) {
        if ($code & error_reporting()) {
            echo PHP_EOL . PHP_EOL . ' Error: ' . $message . PHP_EOL . PHP_EOL;
            exit(1);
        }
    }
);


echo 'ApiGen Installer' . PHP_EOL;
echo '================' . PHP_EOL . PHP_EOL;

// Check php version
if (version_compare(PHP_VERSION, '5.3.1', '>=') === FALSE) {
	echo PHP_EOL . 'Your PHP ' . PHP_VERSION . ' is too old, you must upgrade to PHP 5.3.1 or higher.';
}


// Check phar extension
if ( ! extension_loaded('Phar')) {
	echo PHP_EOL . 'The phar extension is missing.' . PHP_EOL;
}


// Retrieve manifest
$manifest = file_get_contents('http://apigen.org/manifest.json');
$item = json_decode($manifest);


// Download
echo ' - Downloading ApiGen v', $item->version, '...', PHP_EOL;
file_put_contents($item->name, file_get_contents($item->url));


// Check downloaded file - checksum
echo ' - Checking file checksum...' . PHP_EOL;
if ($item->sha1 !== sha1_file($item->name)) {
    unlink($item->name);
    echo ' x The download was corrupted.' . PHP_EOL;
	exit(1);
}


// Check downloaded file - phar
echo ' - Checking if valid Phar...' . PHP_EOL;
try {
    new Phar($item->name);
} catch (Exception $e) {
	unlink($item->name);
    echo ' x The Phar is not valid.' . PHP_EOL . PHP_EOL;
	exit(1);
}


// Make executable
echo ' - Making ApiGen executable...' . PHP_EOL;
@chmod($item->name, 0755);

echo PHP_EOL . 'ApiGen installed!' . PHP_EOL;
echo PHP_EOL . 'Use it: php apigen.phar' . PHP_EOL;
