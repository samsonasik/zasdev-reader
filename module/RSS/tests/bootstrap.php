<?php
$vendorDir = 'vendor';
$dir = __DIR__;
$previousDir = '.';
while (!is_dir($dir . '/' . $vendorDir)) {
    $dir = dirname($dir);
    if ($previousDir === $dir) {
        throw new \RuntimeException("Composer autoload not found");
    }
    $previousDir = $dir;
}
$vendorDir = $dir . '/' . $vendorDir;
require_once $vendorDir . '/autoload.php';
