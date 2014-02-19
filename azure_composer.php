<?php

$target_parameters_file = __DIR__ . "/app/config/parameters.yml";

if(file_exists($target_parameters_file)) unlink($target_parameters_file);
copy(__DIR__ . "/app/config/parameters.yml.azure", $target_parameters_file);


function destroy_dir($dir) {
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
    foreach (scandir($dir) as $file) {
        if ($file == '.' || $file == '..') continue;
        if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) {
            chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
            if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) return false;
        };
    }
    return rmdir($dir);
}

if(is_dir(__DIR__ . "/app/cache/dev")) destroy_dir(__DIR__ . "/app/cache/dev");
if(is_dir(__DIR__ . "/app/cache/prod")) destroy_dir(__DIR__ . "/app/cache/prod");
if(is_dir(__DIR__ . "/app/logs/dev")) destroy_dir(__DIR__ . "/app/logs/dev");
if(is_dir(__DIR__ . "/app/logs/prod")) destroy_dir(__DIR__ . "/app/logs/prod");

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