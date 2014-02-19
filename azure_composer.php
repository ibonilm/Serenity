<?php

$target_parameters_file = __DIR__ . "/app/config/parameters.yml";

if(file_exists($target_parameters_file)) unlink($target_parameters_file);
copy(__DIR__ . "/app/config/parameters.yml.azure", $target_parameters_file);

if (!file_exists("composer.phar")) {
    $url = 'https://getcomposer.org/composer.phar';
    file_put_contents("composer.phar", file_get_contents($url));
}

$_SERVER['argv'][1] = "update";
$_SERVER['argv'][2] = "--no-dev";
$_SERVER['argv'][3] = "--prefer-dist";
$_SERVER['argv'][4] = "-v";
$_SERVER['argv'][5] = "--optimize-autoloader";

require "composer.phar";