<?php

use CodeIgniter\Boot;
use Config\Paths;

$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;
    exit(1);
}

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Auto-clear invalid cross-environment cache if loaded on a different server/OS or path
$rootDir = realpath(__DIR__ . '/..') ?: dirname(__DIR__);
$cacheDir = $rootDir . '/writable/cache';
$cacheConfig = $cacheDir . '/FactoriesCache_config';
if (is_file($cacheConfig)) {
    $content = @file_get_contents($cacheConfig);
    if ($content !== false && (
        (DIRECTORY_SEPARATOR === '/' && strpos($content, 'C:\\') !== false) ||
        (DIRECTORY_SEPARATOR === '\\' && strpos($content, '/www/') !== false) ||
        strpos($content, rtrim($rootDir, '\\/')) === false
    )) {
        @unlink($cacheConfig);
        @unlink($cacheDir . '/FileLocatorCache');
    }
}

require_once FCPATH . '../app/Config/Paths.php';

$paths = new Paths();

require_once $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));

