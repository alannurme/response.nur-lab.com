<?php
namespace App\Helpers;

class Cache {
    private static $cache_dir = APPROOT . '/cache';
    private static $default_expiry = 300; // 5 minutes in seconds

    private static function init() {
        if (!is_dir(self::$cache_dir)) {
            mkdir(self::$cache_dir, 0777, true);
            file_put_contents(self::$cache_dir . '/index.html', '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory browsing is forbidden.</p></body></html>');
        }
    }

    public static function get($key) {
        // Caching disabled: always return null to force database fetch
        return null;
    }

    public static function set($key, $value, $expiry = null) {
        // Caching disabled: return the value directly without saving to file
        return $value;
    }

    public static function delete($key) {
        self::init();
        $file = self::$cache_dir . '/' . md5($key) . '.cache';
        if (file_exists($file)) {
            @unlink($file);
        }
        return true;
    }

    public static function clear() {
        self::init();
        $files = glob(self::$cache_dir . '/*.cache');
        if ($files) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
        return true;
    }
}
