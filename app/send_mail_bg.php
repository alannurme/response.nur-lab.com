<?php
// Define minimal APPROOT
if (!defined('APPROOT')) {
    define('APPROOT', __DIR__);
}

// Load Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Run mail sending
if (isset($argv[1]) && file_exists($argv[1])) {
    $data = json_decode(file_get_contents($argv[1]), true);
    if ($data) {
        \App\Helpers\Mailer::send($data['to'], $data['subject'], $data['message'], $data['settings']);
    }
    @unlink($argv[1]);
}
