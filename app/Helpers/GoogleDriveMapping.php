<?php
namespace App\Helpers;

class GoogleDriveMapping {
    private static $filePath = null;
    private static $cache = null;

    private static function getPath() {
        if (self::$filePath === null) {
            $base = defined('WRITEPATH') ? WRITEPATH : (__DIR__ . '/../../writable/');
            self::$filePath = $base . 'gdrive_mappings.json';
        }
        return self::$filePath;
    }

    /**
     * Get all mappings
     */
    public static function getAll() {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $file = self::getPath();
        if (file_exists($file)) {
            $content = @file_get_contents($file);
            $data = json_decode($content, true);
            if (is_array($data)) {
                self::$cache = $data;
                return self::$cache;
            }
        }

        self::$cache = [];
        return self::$cache;
    }

    /**
     * Find mapping by filename or relative path
     */
    public static function get($key) {
        $all = self::getAll();
        $normalized = self::normalizeKey($key);

        if (isset($all[$normalized])) {
            return $all[$normalized];
        }

        // Also check by basename if key was a full path
        $basename = basename($normalized);
        if (isset($all[$basename])) {
            return $all[$basename];
        }

        return null;
    }

    /**
     * Set a single mapping
     */
    public static function set($key, $data) {
        $all = self::getAll();
        $normalized = self::normalizeKey($key);
        $basename = basename($normalized);

        $entry = [
            'file_id'     => $data['file_id'] ?? ($data['id'] ?? ''),
            'url'         => $data['url'] ?? '',
            'export_url'  => $data['export_url'] ?? '',
            'file_name'   => $data['file_name'] ?? $basename,
            'rel_path'    => $normalized,
            'migrated_at' => $data['migrated_at'] ?? date('Y-m-d H:i:s')
        ];

        $all[$normalized] = $entry;
        // Also map bare filename for fast lookup
        if ($basename !== $normalized) {
            $all[$basename] = $entry;
        }

        self::$cache = $all;
        return self::save($all);
    }

    /**
     * Set multiple mappings at once
     */
    public static function setBatch(array $items) {
        $all = self::getAll();
        foreach ($items as $key => $data) {
            $normalized = self::normalizeKey($key);
            $basename = basename($normalized);
            $entry = [
                'file_id'     => $data['file_id'] ?? ($data['id'] ?? ''),
                'url'         => $data['url'] ?? '',
                'export_url'  => $data['export_url'] ?? '',
                'file_name'   => $data['file_name'] ?? $basename,
                'rel_path'    => $normalized,
                'migrated_at' => $data['migrated_at'] ?? date('Y-m-d H:i:s')
            ];
            $all[$normalized] = $entry;
            if ($basename !== $normalized) {
                $all[$basename] = $entry;
            }
        }
        self::$cache = $all;
        return self::save($all);
    }

    /**
     * Remove a mapping
     */
    public static function remove($key) {
        $all = self::getAll();
        $normalized = self::normalizeKey($key);
        $basename = basename($normalized);

        unset($all[$normalized]);
        if (isset($all[$basename])) {
            unset($all[$basename]);
        }

        self::$cache = $all;
        return self::save($all);
    }

    /**
     * Normalize key (strip leading slashes, public/, etc.)
     */
    public static function normalizeKey($key) {
        $k = str_replace('\\', '/', trim($key));
        $k = ltrim($k, '/');
        if (strpos($k, 'public/') === 0) {
            $k = substr($k, 7);
        }
        return $k;
    }

    private static function save(array $data) {
        $file = self::getPath();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        return @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
    }
}
