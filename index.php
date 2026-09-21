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

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== __DIR__ . DIRECTORY_SEPARATOR) {
    chdir(__DIR__);
}

require_once __DIR__ . '/app/Config/Paths.php';

$paths = new Paths();

require_once $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));

