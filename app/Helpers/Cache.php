<?php
namespace App\Helpers;

class Cache {
    private static $cache_dir = APPROOT . '/cache';
    private static $default_expiry = 300; // 5 minutes in seconds
    private static $redis = null;
    private static $redis_checked = false;

    private static function getRedisInstance() {
        if (!self::$redis_checked) {
            self::$redis_checked = true;
            if (extension_loaded('redis')) {
                try {
                    $r = new \Redis();
                    if (@$r->connect('127.0.0.1', 6379, 1.5)) {
                        self::$redis = $r;
                    }
                } catch (\Throwable $e) {
                    self::$redis = null;
                }
            }
        }
        return self::$redis;
    }

    private static function init() {
        if (!is_dir(self::$cache_dir)) {
            @mkdir(self::$cache_dir, 0777, true);
            @file_put_contents(self::$cache_dir . '/index.html', '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory browsing is forbidden.</p></body></html>');
        }
    }

    public static function get($key) {
        $redis = self::getRedisInstance();
        if ($redis) {
            try {
                $data = $redis->get($key);
                if ($data !== false) {
                    return unserialize($data);
                }
            } catch (\Throwable $e) {
                // Fallback to file cache
            }
        }

        // File Cache Fallback
        self::init();
        $file = self::$cache_dir . '/' . md5($key) . '.cache';
        if (file_exists($file)) {
            $content = @file_get_contents($file);
            if ($content) {
                $data = @unserialize($content);
                if ($data && isset($data['expiry']) && isset($data['value'])) {
                    if ($data['expiry'] > time()) {
                        return $data['value'];
                    } else {
                        @unlink($file);
                    }
                }
            }
        }
        return null;
    }

    public static function set($key, $value, $expiry = null) {
        $ttl = $expiry ? (int)$expiry : self::$default_expiry;

        $redis = self::getRedisInstance();
        if ($redis) {
            try {
                $redis->setex($key, $ttl, serialize($value));
                return $value;
            } catch (\Throwable $e) {
                // Fallback to file cache
            }
        }

        // File Cache Fallback
        self::init();
        $file = self::$cache_dir . '/' . md5($key) . '.cache';
        $data = [
            'expiry' => time() + $ttl,
            'value'  => $value
        ];
        @file_put_contents($file, serialize($data));
        return $value;
    }

    public static function delete($key) {
        $redis = self::getRedisInstance();
        if ($redis) {
            try {
                $redis->del($key);
            } catch (\Throwable $e) {}
        }

        self::init();
        $file = self::$cache_dir . '/' . md5($key) . '.cache';
        if (file_exists($file)) {
            @unlink($file);
        }
        return true;
    }

    public static function clear() {
        $redis = self::getRedisInstance();
        if ($redis) {
            try {
                $redis->flushDB();
            } catch (\Throwable $e) {}
        }

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
